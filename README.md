# MyNotes App

Prosty menedżer notatek zbudowany w PHP, PostgreSQL oraz czystym HTML/CSS/JS. Możesz:

- Tworzyć i edytować notatki z tytułami, treścią oraz tagami rozdzielanymi przecinkami
- Oznaczać notatki jako „ulubione” (★) i filtrować tylko ulubione
- Filtrować notatki według poszczególnych tagów
- Zarządzać swoim profilem (imię, e-mail, avatar) oraz zmieniać hasło

---

## Spis treści

1. [ERD – Diagram bazy danych](#erd)
2. [Prototyp](#prototyp)
3. [Instalacja](#instalacja)
4. [Użycie](#uzycie)
5. [Screenshots](#screenshots)
6. [Profile Settings](#profile-settings)
7. [Architektura i OOP](#architektura-i-oop)

---

## ERD

```mermaid
erDiagram
    USERS ||--o{ USER_PROFILES : has
    USERS ||--o{ NOTES         : owns
    NOTES ||--o{ NOTE_TAGS     : links
    TAGS  ||--o{ NOTE_TAGS     : links

    USERS {
      int    id PK
      string email
      string password_hash
      timestamp created_at
    }
    USER_PROFILES {
      int    user_id PK,FK
      string full_name
      string avatar_path
    }
    NOTES {
      int    id PK
      int    user_id FK
      string title
      text   content
      bool   is_favorite
      timestamp created_at
      timestamp updated_at
    }
    TAGS {
      int    id PK
      string name
    }
    NOTE_TAGS {
      int note_id FK
      int tag_id  FK
      PK(note_id,tag_id)
    }

```

---

## Prototyp

Prototyp interfejsu znajdziesz lokalnie w pliku `docs/prototype.pdf`.

---

## Instalacja

```bash
git clone <repo-url>
docker compose up --build
```

Aplikacja będzie dostępna pod `http://localhost:8080`.

---

## Użycie

- Zarejestruj nowe konto lub zaloguj się
- Przejdź do `My Notes` (lista notatek)
- Kliknij **+ New Note** aby dodać nową
- Edytuj, usuwaj, oznaczaj jako ulubione lub filtruj po tagach
- W ustawieniach profilu (⚙) zarządzaj danymi i avatarami

---

## Screenshots

- **login.png** – strona logowania
  [Logowanie](docs/screenshots/login.png)
- **register.png** – strona rejestracji
  [Rejestracja](docs/screenshots/register.png)
- **list.png** – widok główny: lista notatek z filtrem tagów i gwiazdkami
  [Lista notatek](docs/screenshots/list.png)
- **new-note.png** – formularz tworzenia nowej notatki
  [Nowa notatka](docs/screenshots/new-note.png)
- **edit-note.png** – formularz edycji notatki
  [Edycja notatki](docs/screenshots/edit-note.png)
- **profile-settings.png** – strona ustawień profilu
  [Profil](docs/screenshots/profile-settings.png)

---

## Profile Settings

Formularz pozwalający na:

- Zmianę zdjęcia profilowego (avatar)
- Aktualizację pełnej nazwy i emaila
- Zmianę hasła (wymaga podania starego)

---

## Architektura i OOP

- `src/Models` – encje danych (`User`, `Note`)
- `src/Repositories` – dostęp do DB z użyciem PDO
- `src/Controllers` – kontrolery obsługujące logikę MVC
- `public/Views` – widoki PHP + HTML
- `Routing.php` – prosty front-controller mapujący URL → metoda
- `styles/`, `assets/` – czysty CSS/JS (bez frameworków)

---
