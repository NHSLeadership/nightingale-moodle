/**
 * Created by ishani on 02/08/2017.
 */
M.theme_nhsla_nightingale = M.theme_nhsla_nightingale || {};
M.theme_nhsla_nightingale.main = {};
M.theme_nhsla_nightingale.main.init = function(Y) {

    // Start hiding default Moodle stuff not required in the theme
        document.querySelector("a[href='#maincontent']").style.display = 'none';
    // End of Default Moodle stuff


    // Theme NHSLA Nightingale JS

    var setupToggles = function() {
        if (window.innerWidth > 720) {
            // Get all the submenus
            var submenus = document.querySelectorAll('.jsNavSub')

            Array.prototype.forEach.call(submenus, function(submenu) {
                var clone = submenu.cloneNode(true)
                var wrapper = document.getElementById('jsPageHeader')
                wrapper.appendChild(clone)
                submenu.parentNode.removeChild(submenu)
            })
        }
    }

    setupToggles()

    function getDisplayMode(target) {
        var displayMode = target.currentStyle ? target.currentStyle.display : window.getComputedStyle(target, null).display
        return displayMode
    }

    function toggle(toggleButton, target, popupMode, displayMode) {
        var expanded = toggleButton.getAttribute('aria-expanded') === 'true'
        expanded = !expanded
        toggleButton.setAttribute('aria-expanded', expanded)
        target.style.display = target.style.display === 'none' ? displayMode : 'none'

        // Get header class value
        var header = document.getElementById('jsPageHeader')
        var headerClasses = header.getAttribute('class')

        // Do header class
        // if it's a submenu that's been opened
        if (expanded && target.getAttribute('aria-label') === 'submenu') {
            header.setAttribute('class', headerClasses + ' has-sub-nav')
        } else {
            header.setAttribute('class', headerClasses.replace(' has-sub-nav', ''))
        }

        if (expanded && popupMode) {
            // Get the first and last focusable elements
            var first = target.querySelector('a[href], button, input, textarea, select, [tabindex="0"]')
            var all = target.querySelectorAll('a[href], button, input, textarea, select, [tabindex="0"]')
            var last = all[all.length - 1]

            // Focus the first focusable elem
            first.focus()

            // Refocus `toggleButton` if the user
            // presses Shift + Tab on first focusable elem
            first.addEventListener('keydown', function(e) {
                var key = 'which' in e ? e.which : e.keyCode;
                if (key === 9 && e.shiftKey) {
                    e.preventDefault()
                    toggleButton.focus()
                }
            })

            // Refocus `toggleButton` if the user
            // presses Tab on last focusable elem
            last.addEventListener('keydown', function(e) {
                var key = 'which' in e ? e.which : e.keyCode;
                if (key === 9 && !e.shiftKey) {
                    e.preventDefault()
                    toggleButton.focus()
                }
            })
        }
    }

    // Get all the toggle button nodes in the document
    var toggleButtons = document.querySelectorAll('[data-expands]')

    // Iterate over those buttons
    Array.prototype.forEach.call(toggleButtons, function(toggleButton) {
        // Give the element the button role
        toggleButton.setAttribute('role', 'button')

        // Set the aria-expanded value to false to begin with
        toggleButton.setAttribute('aria-expanded', 'false')

        // Define the target element via the selector supplied
        // as the `data-expands` value
        var target = document.querySelector(toggleButton.getAttribute('data-expands'))

        // If it has `data-popup` give it `aria-haspopup`
        // and set it to popupMode
        if (toggleButton.getAttribute('data-popup') !== null) {
            toggleButton.setAttribute('aria-haspopup', 'true')
            var popupMode = true

            // Give the target the right semantics too
            target.setAttribute('role', 'group')
            target.setAttribute('aria-label', 'submenu')
        }

        // Get and set displayMode
        var displayMode = getDisplayMode(target)
        if (displayMode === 'none') {
            target.style.display = 'none'
            displayMode = 'block'
        }

        toggleButton.addEventListener('click', function() {
            // Do the toggling
            toggle(toggleButton, target, popupMode, displayMode)
        })

        // Close menu on outside click
        document.addEventListener('click', function(e) {
            if ((!target.contains(e.target) && toggleButton !== e.target) && toggleButton.getAttribute('aria-expanded') === 'true') {
                toggleButton.click()
            }
        })
    })

    // Hamburger menu text node toggle
    var navTrigger = document.getElementById('jsNavTrigger');
        navTrigger.addEventListener('click', function() {
        this.innerHTML = this.innerHTML === '×' ? '☰' : '×'
    });

        // End of Theme NHSLA Nightingale JS

};