/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

// enable the interactive UI components from Flowbite with Turbo
import 'flowbite/dist/flowbite.turbo.js';

import "./js/sidebar"
import "./js/dark-mode"


let forms = Array.from(document.getElementsByTagName("form"))

forms.forEach(form => {
    form.noValidate = true
})

const mainNavbar = document.getElementById("main-navbar")
const contentWithoutFilter = document.getElementById("content-without-footer")
const mainFooter = document.getElementById("main-footer")

contentWithoutFilter.style.minHeight = `calc(100vh - ${mainNavbar.offsetHeight + mainFooter.offsetHeight + 20}px)`