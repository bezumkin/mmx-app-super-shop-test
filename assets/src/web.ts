// @ts-nocheck
// import {createApp} from 'vue'
// import {createMmxToast} from '@vesp/mmx-frontend/toast'
// import {setNamespace} from '@vesp/mmx-frontend/namespace'
// import App from './web/app.vue'
import GLightbox from 'glightbox'
import 'glightbox/dist/css/glightbox.css'
import './web/scss/index.scss'

document.addEventListener('DOMContentLoaded', () => {
  /*
  const appRoot = document.getElementById('mmx-super-shop-root')
  if (appRoot) {
    setNamespace('mmx-super-shop')
    createApp(App).use(createMmxToast()).mount(appRoot)
  }
  */
  const el = document.getElementById('mmx-gallery')
  if (el) {
    GLightbox({
      touchNavigation: true,
      loop: true,
    })
  }
})
