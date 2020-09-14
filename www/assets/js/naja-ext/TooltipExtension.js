export default class TooltipExtension {
    constructor(selector) {
        this.selector = selector;
    }

    initialize(naja) {
        naja.addEventListener('init', this.init.bind(this));
        naja.addEventListener('complete', this.init.bind(this));
    }

    init() {
        document.querySelectorAll(this.selector).forEach(element => {
            $(element).tooltip();
        });
    }
}