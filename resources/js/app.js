import "flowbite";
import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
