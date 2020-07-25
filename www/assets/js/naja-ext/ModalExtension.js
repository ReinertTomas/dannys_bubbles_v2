export default class ModalExtension {
    constructor(selector) {
        this.selector = selector;
    }

    initialize(naja) {
        naja.addEventListener('success', this.showModal.bind(this));
    }

    showModal({detail}) {
        if (detail.payload.snippets) {
            if (detail.payload.snippets['snippet--modal']) {
                $(this.selector).modal('show');
            }
        }
    }
}