import Alpine from 'alpinejs';

window.Alpine = Alpine;

/**
 * Carrossel INFINITO de produtos em destaque.
 *
 * Os itens são renderizados 3x (clone | reais | clone). O usuário fica sempre
 * no conjunto do meio; ao cruzar para um clone (via swipe ou seta), o scroll é
 * reposicionado instantaneamente para o conjunto do meio equivalente — como o
 * conteúdo é idêntico, o loop parece infinito e contínuo.
 *
 * Efeito "peek": cada card ocupa 50% da largura e fica centralizado (snap-center),
 * mostrando metade do anterior à esquerda e metade do próximo à direita.
 */
Alpine.data('carrossel', () => ({
    n: 0,            // qtd de produtos reais
    idx: 0,          // índice do slide centralizado (na lista triplicada)
    scrollable: false,
    _lock: false,
    _tCenter: null,
    _tScroll: null,

    init() {
        this.$nextTick(() => this.setup());
        window.addEventListener('resize', () => this.setup());
        // recalcula após imagens carregarem (evita desalinhamento)
        window.addEventListener('load', () => this.setup());
    },

    slides() {
        return this.$refs.track ? this.$refs.track.querySelectorAll('[data-slide]') : [];
    },

    setup() {
        const t = this.$refs.track;
        if (!t) return;
        const s = this.slides();
        if (!s.length) return;
        this.n = s.length / 3;
        this.scrollable = this.n > 1;
        if (!this.scrollable) return;
        this.idx = this.n; // primeiro slide do conjunto do meio
        this.centralizar(this.idx, false);
    },

    centralizar(i, suave = true) {
        const t = this.$refs.track;
        const el = this.slides()[i];
        if (!t || !el) return;
        // Alinha o card deixando meia-largura de peek à esquerda.
        // card 50% -> 1 produto centralizado (mobile); card 33% -> 2 produtos (desktop)
        const x = el.offsetLeft - el.offsetWidth / 2;
        this._lock = true;
        t.style.scrollBehavior = suave ? 'smooth' : 'auto';
        t.scrollLeft = x;
        clearTimeout(this._tCenter);
        this._tCenter = setTimeout(() => {
            this._lock = false;
            this.normalizar();
        }, suave ? 450 : 60);
    },

    // Mantém o índice sempre dentro do conjunto do meio, reposicionando de forma invisível
    normalizar() {
        if (!this.scrollable) return;
        if (this.idx < this.n) {
            this.idx += this.n;
            this.centralizar(this.idx, false);
        } else if (this.idx >= this.n * 2) {
            this.idx -= this.n;
            this.centralizar(this.idx, false);
        }
    },

    next() {
        if (!this.scrollable) return;
        this.idx++;
        this.centralizar(this.idx, true);
    },

    prev() {
        if (!this.scrollable) return;
        this.idx--;
        this.centralizar(this.idx, true);
    },

    // Swipe livre: quando o usuário para de arrastar, encaixa no card mais próximo e normaliza
    aoRolar() {
        if (this._lock || !this.scrollable) return;
        clearTimeout(this._tScroll);
        this._tScroll = setTimeout(() => {
            if (this._lock) return;
            const t = this.$refs.track;
            const s = this.slides();
            let melhor = 0, dist = Infinity;
            s.forEach((el, i) => {
                const pos = el.offsetLeft - el.offsetWidth / 2; // posição de alinhamento do card
                const d = Math.abs(pos - t.scrollLeft);
                if (d < dist) { dist = d; melhor = i; }
            });
            this.idx = melhor;
            this.centralizar(this.idx, true); // encaixa suavemente (snap por JS)
        }, 140);
    },
}));

Alpine.start();
