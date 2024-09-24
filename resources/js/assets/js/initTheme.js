import $ from 'jquery'
import * as bootstrap from 'bootstrap'

window.$ = window.jQuery = $
window.bootstrap = bootstrap

const body = document.body
const theme = localStorage.getItem('theme')

if (theme) document.documentElement.setAttribute('data-bs-theme', theme)
