import Alpine from 'alpinejs';

window.Alpine = Alpine;

/**
 * Carrossel de produtos em destaque.
 * Usa scroll-snap nativo (swipe no mobile) + setas no desktop.
 * As setas e o estado de borda (inicio/fim) só aparecem quando há
 * conteúdo suficiente para rolar — caso contrário vira uma grade comum.
 */
Alpine.data('carrossel', () => ({
    scrollable: false,
    atInicio: true,
    atFim: false,

    init() {
        this.$nextTick(() => this.atualiza());
        window.addEventListener('resize', () => this.atualiza());
    },

    atualiza() {
        const t = this.$refs.track;
        if (!t) return;
        this.scrollable = t.scrollWidth > t.clientWidth + 4;
        this.atInicio = t.scrollLeft <= 4;
        this.atFim = t.scrollLeft + t.clientWidth >= t.scrollWidth - 4;
    },

    prev() {
        const t = this.$refs.track;
        t.scrollBy({ left: -t.clientWidth * 0.5, behavior: 'smooth' });
    },

    next() {
        const t = this.$refs.track;
        t.scrollBy({ left: t.clientWidth * 0.5, behavior: 'smooth' });
    },
}));

Alpine.start();
