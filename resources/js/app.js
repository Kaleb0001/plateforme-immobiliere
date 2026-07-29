import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);

/**
 * Directive x-reveal : fait apparaitre un element (fondu + leger deplacement)
 * quand il entre dans le viewport. Reutilisable sur n'importe quelle section :
 * <div x-reveal>...</div>
 */
Alpine.directive('reveal', (el) => {
    el.style.opacity = 0;
    el.style.transform = 'translateY(16px)';
    el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                el.style.opacity = 1;
                el.style.transform = 'translateY(0)';
                observer.unobserve(el);
            }
        });
    }, { threshold: 0.15 });

    observer.observe(el);
});

window.Alpine = Alpine;
Alpine.start();
