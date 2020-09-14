/**
 * Naja conf file
 */
import naja from "naja";
import ModalExtension from "./naja-ext/ModalExtension";
import TooltipExtension from "./naja-ext/TooltipExtension";

// Register loader
naja.registerExtension(new ModalExtension('#layoutModal'));
naja.registerExtension(new TooltipExtension('[data-toggle=tooltip]'));

// We must attach Naja to window load event.
document.addEventListener('DOMContentLoaded', () => naja.initialize());

// export naja object
export default naja;