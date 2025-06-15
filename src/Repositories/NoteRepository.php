<?php
require_once 'Repository.php';
require_once __DIR__.'/../Models/Note.php';

class NoteRepository extends Repository
{
    private function pgArrayToPhp(string $pgArray): array
    {
        $trim = trim($pgArray, '{}');
        if ($trim === '') {           // pusty
            return [];
        }
        return array_map('trim', explode(',', $trim));
    }
    public function allByUser(int $userId): array
    {
        $sql = "
            SELECT *
            FROM view_notes_with_tags
            WHERE user_id = :uid
            ORDER BY created_at DESC
        ";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute([':uid' => $userId]);

        $rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $notes = [];

        foreach ($rows as $r) {
            $tagArray = $this->pgArrayToPhp($r['tag_arr'] ?? '{}');
            $notes[] = new Note(
                $r['id'],
                $r['user_id'],
                $r['title'],
                $r['content'] ?? '',
                $tagArray,
                $r['is_favorite'],
                $r['created_at']
            );
        }
        return $notes;
    }

    public function save(Note $note): int
    {
        $c = $this->db->connect();
        try {
            $c->beginTransaction();

            $stmt = $c->prepare(
                "INSERT INTO notes (user_id, title, content, is_favorite)
                    VALUES (:uid, :title, :content, :fav)
                    RETURNING id"
            );
            $stmt->bindValue(':uid',     $note->getUserId(), PDO::PARAM_INT);
            $stmt->bindValue(':title',   $note->getTitle(),  PDO::PARAM_STR);
            $stmt->bindValue(':content', $note->getContent(),PDO::PARAM_STR);
            $stmt->bindValue(':fav',     $note->isFavorite(),PDO::PARAM_BOOL);

            $stmt->execute();
            $noteId = (int) $stmt->fetchColumn();

            $tagStmt = $c->prepare(
                "INSERT INTO tags(name) VALUES(:n)
                    ON CONFLICT(name) DO UPDATE SET name = EXCLUDED.name
                    RETURNING id"
            );
            $relStmt = $c->prepare(
                "INSERT INTO note_tags(note_id, tag_id)
                    VALUES(:nid, :tid) ON CONFLICT DO NOTHING"
            );

            foreach ($note->getTags() as $name) {
                $tagStmt->execute([':n' => trim($name)]);
                $tagId = (int) $tagStmt->fetchColumn();
                $relStmt->execute([':nid' => $noteId, ':tid' => $tagId]);
            }

            $c->commit();
            return $noteId;
        } catch (Throwable $e) {
            $c->rollBack();
            throw $e;
        }
    }
    public function deleteById(int $noteId, int $userId): void
    {
        $sql = 'DELETE FROM notes WHERE id = :nid AND user_id = :uid';
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute([':nid' => $noteId, ':uid' => $userId]);
    }
    public function update(Note $note): void
    {
        $c = $this->db->connect();
        try {
            $c->beginTransaction();

            $stmt = $c->prepare(
            'UPDATE notes
                SET title = :title,
                    content = :content,
                    is_favorite = :fav
            WHERE id = :nid AND user_id = :uid'
            );
    
            $stmt->bindValue(':title', $note->getTitle(), PDO::PARAM_STR);
            $stmt->bindValue(':content', $note->getContent(), PDO::PARAM_STR);
            $stmt->bindValue(':fav', $note->isFavorite(), PDO::PARAM_BOOL);
            $stmt->bindValue(':nid', $note->getId(), PDO::PARAM_INT);
            $stmt->bindValue(':uid', $note->getUserId(), PDO::PARAM_INT);

            $stmt->execute();
     
            $c->prepare('DELETE FROM note_tags WHERE note_id = :nid')
            ->execute([':nid' => $note->getId()]);

            $tagStmt = $c->prepare(
                'INSERT INTO tags(name) VALUES(:n)
                ON CONFLICT(name) DO UPDATE SET name = EXCLUDED.name
                RETURNING id'
            );
            $relStmt = $c->prepare(
                'INSERT INTO note_tags(note_id, tag_id)
                VALUES(:nid, :tid) ON CONFLICT DO NOTHING'
            );

            foreach ($note->getTags() as $tag) {
                $tagStmt->execute([':n' => trim($tag)]);
                $tagId = (int) $tagStmt->fetchColumn();
                $relStmt->execute([':nid' => $note->getId(), ':tid' => $tagId]);
            }

            $c->commit();
        } catch (Throwable $e) {
            $c->rollBack();
            throw $e;
        }
    }
    public function toggleFavorite(int $noteId, int $userId): void
    {
        $sql = 'UPDATE notes
                SET is_favorite = NOT is_favorite
                WHERE id = :nid AND user_id = :uid';
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute([':nid' => $noteId, ':uid' => $userId]);
    }
}