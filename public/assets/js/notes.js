document.addEventListener("DOMContentLoaded", () => {
  const filterBar = document.querySelector(".tag-filter");
  const cards = document.querySelectorAll(".note-card");

  filterBar.addEventListener("click", (e) => {
    const btn = e.target.closest(".tag");
    if (!btn) return;

    filterBar
      .querySelectorAll(".tag")
      .forEach((b) => b.classList.toggle("active", b === btn));

    const tag = btn.dataset.tag;

    cards.forEach((card) => {
      const tagList = card.dataset.tags.split(" ");
      const isFav = card.dataset.fav === "1";

      const show =
        tag === "all" ? true : tag === "fav" ? isFav : tagList.includes(tag);

      card.style.display = show ? "" : "none";
    });
  });
});
