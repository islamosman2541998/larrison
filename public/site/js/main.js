// swiper header
// Mobile Menu
const burger = document.getElementById("navBurger");
const links = document.getElementById("navLinks");

if (burger && links) {
  burger.addEventListener("click", () => {
    links.classList.toggle("open");
  });
}

// Navbar scroll effect
const navWrap = document.querySelector(".nav-wrap");
window.addEventListener("scroll", () => {
  if (!navWrap) return;
  navWrap.classList.toggle("is-scrolled", window.scrollY > 10);
});

// Swiper Hero
const heroSwiper = new Swiper("#heroSwiper", {
  loop: true,
  speed: 900,
  effect: "slide",
  autoplay: {
    delay: 4500,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});
// Categories Tabs (Works with Bootstrap HTML: .nav-link + data-bs-target + .tab-pane)
document.addEventListener("DOMContentLoaded", () => {
  const tabs = document.querySelectorAll("#catsTabs .nav-link");
  const panes = document.querySelectorAll("#catsTabsContent .tab-pane");

  if (!tabs.length || !panes.length) return;

  const activate = (targetSelector) => {
    // Tabs active
    tabs.forEach(t => {
      t.classList.remove("active");
      t.setAttribute("aria-selected", "false");
    });

    const activeTab = document.querySelector(`#catsTabs .nav-link[data-bs-target="${targetSelector}"]`);
    if (activeTab) {
      activeTab.classList.add("active");
      activeTab.setAttribute("aria-selected", "true");
    }

    // Panes show/hide (Bootstrap style)
    panes.forEach(p => {
      p.classList.remove("show", "active");
    });

    const activePane = document.querySelector(targetSelector);
    if (activePane) {
      activePane.classList.add("show", "active");
    }
  };

  // Default tab (active one in HTML) or first tab
  const defaultTarget =
    document.querySelector('#catsTabs .nav-link.active')?.getAttribute("data-bs-target") ||
    tabs[0].getAttribute("data-bs-target");

  activate(defaultTarget);

  // Click events
  tabs.forEach(tab => {
    tab.addEventListener("click", (e) => {
      e.preventDefault();
      const target = tab.getAttribute("data-bs-target");
      if (target) activate(target);
    });
  });
});
// best seller
document.addEventListener("DOMContentLoaded", () => {
  const el = document.querySelector(".bs-swiper");
  if (!el) return;

  new Swiper(".bs-swiper", {
    loop: true,
    spaceBetween: 18,
    speed: 700,

    pagination: {
      el: ".bs-pagination",
      clickable: true,
    },

    navigation: {
      nextEl: ".bs-next",
      prevEl: ".bs-prev",
    },

    breakpoints: {
      0:   { slidesPerView: 1.1 },
      576: { slidesPerView: 2.1 },
      992: { slidesPerView: 3.2 },
      1200:{ slidesPerView: 4 },
    },
  });
});
// testimionials
document.addEventListener("DOMContentLoaded", () => {
  const section = document.querySelector("#testimonials");
  if (!section) return;

  const swiperEl = section.querySelector(".testi-swiper");
  const nextBtn  = section.querySelector(".testi-next");
  const prevBtn  = section.querySelector(".testi-prev");
  const pagEl    = section.querySelector(".testi-pagination");

  new Swiper(swiperEl, {
    loop: true,
    spaceBetween: 18,
    speed: 700,
    pagination: {
      el: pagEl,
      clickable: true,
    },
    navigation: {
      nextEl: nextBtn,
      prevEl: prevBtn,
    },
    breakpoints: {
      0:    { slidesPerView: 1.1 },
      576:  { slidesPerView: 2.1 },
      992:  { slidesPerView: 3 },
    }
  });
});
// FAQ toggle
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".faq-question").forEach(question => {
        question.addEventListener("click", () => {
            const item = question.parentElement;

            document.querySelectorAll(".faq-item").forEach(i => {
                if (i !== item) {
                    i.classList.remove("active");
                }
            });

            item.classList.toggle("active");
        });
    });
});
// category page
document.addEventListener("DOMContentLoaded", () => {
  const tabs = document.querySelectorAll(".category-tab");
  const cards = document.querySelectorAll(".category-item");
  const searchInput = document.getElementById("categorySearch");

  let activeTab = "all";

  function filterCards() {
    const searchValue = searchInput.value.trim().toLowerCase();

    cards.forEach(card => {
      const category = card.dataset.category.toLowerCase();
      const text = card.textContent.toLowerCase();

      const matchesTab = activeTab === "all" || category === activeTab;
      const matchesSearch = text.includes(searchValue);

      if (matchesTab && matchesSearch) {
        card.classList.remove("hidden");
      } else {
        card.classList.add("hidden");
      }
    });
  }

  tabs.forEach(tab => {
    tab.addEventListener("click", () => {
      tabs.forEach(t => t.classList.remove("active"));
      tab.classList.add("active");
      activeTab = tab.dataset.tab;
      filterCards();
    });
  });

  searchInput.addEventListener("input", filterCards);

  filterCards();
});