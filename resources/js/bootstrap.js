import axios from 'axios';
import Swal from 'sweetalert2';

window.axios = axios;

window.Swal = Swal;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

window.Quill = Quill;

import Highcharts from 'highcharts';
window.Highcharts = Highcharts;

