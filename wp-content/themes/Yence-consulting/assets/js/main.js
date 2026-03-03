// Vanilla JS entry
document.addEventListener("DOMContentLoaded", () => {
  initSimpleSwipers();
  initBurgerMenu();

  // Lenis smooth scroll
  if (window.Lenis) {
    const lenis = new Lenis();
    function raf(time) {
      lenis.raf(time);
      requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);
  }

  // GSAP small demo
  if (window.gsap) {
    gsap.from(".site-header", {
      y: -40,
      opacity: 0,
      duration: 0.6,
      ease: "power2.out",
    });
  }

  function initSimpleSwipers() {
    document.querySelectorAll(".swiper").forEach((el) => {
      // 🔧 Lis les attributs HTML personnalisés
      const perView = parseFloat(el.getAttribute("slide-per-view")) || 2;
      const space = parseFloat(el.getAttribute("space-between")) || 16;
      const delay = parseInt(el.getAttribute("autoplay-delay")) || 5000;
      const loop = el.hasAttribute("loop"); // true si <div loop>

      console.log({ perView, space, delay, loop });

      // Si "no" → pas d'initialisation Swiper, juste du CSS
      if (el.classList.contains("no")) {
        el.style.setProperty("--slides", perView);
        el.style.setProperty("--space-between", space + "px");
        return;
      }

      if (el.swiper) return; // déjà initialisé
      new Swiper(el, {
        loop: loop,
        speed: 600,
        autoplay: { delay: delay, disableOnInteraction: false },
        pagination: {
          el: el.querySelector(".swiper-pagination"),
          clickable: true,
        },
        slidesPerView: 1,
        spaceBetween: space,
        breakpoints: {
          768: { slidesPerView: 2 },
          1024: { slidesPerView: perView },
        },
      });
    });
  }

  /**
   * Initialisation du menu burger et gestion des sous-menus mobile
   */
  function initBurgerMenu() {
    const burgerBtn = document.querySelector(".burger-menu");
    const mainNav = document.querySelector(".main-nav");
    const menuOverlay = document.querySelector(".menu-overlay");
    const body = document.body;

    if (!burgerBtn || !mainNav) return;

    // Toggle burger menu
    burgerBtn.addEventListener("click", () => {
      const isExpanded = burgerBtn.getAttribute("aria-expanded") === "true";

      burgerBtn.setAttribute("aria-expanded", !isExpanded);
      mainNav.classList.toggle("active");
      menuOverlay?.classList.toggle("active");
      body.style.overflow = isExpanded ? "" : "hidden";
    });

    // Fermer le menu en cliquant sur l'overlay
    menuOverlay?.addEventListener("click", () => {
      burgerBtn.setAttribute("aria-expanded", "false");
      mainNav.classList.remove("active");
      menuOverlay.classList.remove("active");
      body.style.overflow = "";
    });

    // Gestion des sous-menus mobile (accordéon)
    const menuItemsWithChildren = document.querySelectorAll(
      ".nav-menu > li.menu-item-has-children",
    );

    menuItemsWithChildren.forEach((item) => {
      const link = item.querySelector(":scope > a");
      const submenu = item.querySelector(".sub-menu");

      if (!link || !submenu) return;

      // Empêcher le lien parent de naviguer sur mobile
      link.addEventListener("click", (e) => {
        if (window.innerWidth <= 767) {
          e.preventDefault();

          // Toggle le sous-menu
          const isActive = item.classList.contains("active");

          // Fermer tous les autres sous-menus
          menuItemsWithChildren.forEach((otherItem) => {
            if (otherItem !== item) {
              otherItem.classList.remove("active");
              otherItem.querySelector(".sub-menu")?.classList.remove("active");
            }
          });

          // Toggle le sous-menu actuel
          item.classList.toggle("active");
          submenu.classList.toggle("active");
        }
      });
    });

    // Fermer le menu lors du redimensionnement de la fenêtre (retour desktop)
    let resizeTimer;
    window.addEventListener("resize", () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        if (window.innerWidth > 767) {
          burgerBtn.setAttribute("aria-expanded", "false");
          mainNav.classList.remove("active");
          menuOverlay?.classList.remove("active");
          body.style.overflow = "";

          // Réinitialiser les sous-menus
          menuItemsWithChildren.forEach((item) => {
            item.classList.remove("active");
            item.querySelector(".sub-menu")?.classList.remove("active");
          });
        }
      }, 250);
    });
  }
});
