import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// Bootstrap JavaScript (requires Popper which is included with Bootstrap when imported from package)
import "bootstrap";
