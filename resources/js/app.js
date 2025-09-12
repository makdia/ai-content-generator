require('./bootstrap'); // optional
import Vue from 'vue';

import AIForm from './components/AIForm.vue';

Vue.config.productionTip = false;

new Vue({
  el: '#app',
  components: { AIForm },
});
