/**
 * Created by ishani on 02/08/2017.
 */
M.theme_nhsla_nightingale = M.theme_nhsla_nightingale || {};
M.theme_nhsla_nightingale.main = {};
M.theme_nhsla_nightingale.main.init = function(Y, is_student) {

    // Modify default Moodle stuff to match with Nightingale theme

        // Hiding forum Group Selector if logged in user is Student
        if(is_student == true) {
            $(".groupselector").hide();
        }

    // End of Moodle Modification


    // Theme NHSLA Nightingale JS

    // Submenus script

    function toggleSubmenu(expander) {
        var expanded = expander.getAttribute('aria-expanded') === 'true';
        expanded = !expanded;
        expander.setAttribute('aria-expanded', expanded);
        var target = document.getElementById(expander.getAttribute('data-expands'));
        target.style.display = target.style.display === 'none' ? 'block' : 'none';

        var header = document.querySelector('#jsPageHeader');
        var headerClasses = header.getAttribute('class');

        if (expanded) {
            header.setAttribute('class', headerClasses + ' has-submenu');
        } else {
            header.setAttribute('class', headerClasses.replace(' has-submenu', ''));
        }

        // Get the first and last focusable elements
        var first = target.querySelector('a[href], button, input, textarea, select, [tabindex="0"]');
        var all = target.querySelectorAll('a[href], button, input, textarea, select, [tabindex="0"]');
        var last = all[all.length - 1];

        // Focus the first focusable elem
        first.focus();

        // Refocus `toggleButton` if the user
        // presses Shift + Tab on first focusable elem
        first.addEventListener('keydown', function(e) {
            var key = 'which' in e ? e.which : e.keyCode;
            if (key === 9 && e.shiftKey) {
                e.preventDefault();
                expander.focus();
            }
        });

        // Refocus `toggleButton` if the user
        // presses Tab on last focusable elem
        last.addEventListener('keydown', function(e) {
            var key = 'which' in e ? e.which : e.keyCode;
            if (key === 9 && !e.shiftKey) {
                e.preventDefault();
                expander.focus();
            }
        });
    }

    function setupNav() {
        var nav = document.getElementById('jsNav');
        var navItems = document.querySelectorAll('#jsNav > li');
        Array.prototype.forEach.call(navItems, function (item) {
            var ul = item.parentNode;
            var index = Array.prototype.indexOf.call(ul.children, item);
            item.setAttribute('data-nav-index', index + 1);
            var sub = item.querySelector('.jsNavSub');
            if (sub) {
                sub.setAttribute('id', 'sub-menu-' + (index + 1));
                sub.setAttribute('role', 'group');
                sub.setAttribute('aria-label', 'sub menu');
                sub.style.display = 'none';

                var expander = item.querySelector('button');
                expander.setAttribute('data-expands', 'sub-menu-' + (index + 1));
                expander.setAttribute('aria-expanded', 'false');
                expander.setAttribute('aria-haspopup', 'true');

                expander.addEventListener('click', function () {
                    toggleSubmenu(expander);
                })
            }
        })
    }

    function moveSubmenus() {
        // Get all the submenus
        var submenus = document.querySelectorAll('.jsNavSub');

        Array.prototype.forEach.call(submenus, function(submenu) {
            if (window.innerWidth > 720) {
                if (document.querySelector('#jsNav > li .jsNavSub')) {
                    var clone = submenu.cloneNode(true);
                    var wrapper = document.querySelector('#jsPageHeader');
                    wrapper.appendChild(clone);
                    submenu.parentNode.removeChild(submenu);
                }
            } else {
                if (document.querySelector('.jsPageHeader > .jsNavSub')) {
                    var clone = submenu.cloneNode(true);
                    var id = submenu.getAttribute('id');
                    var index = id.substr(id.length - 1);
                    var wrapper = document.querySelector('[data-nav-index="' + index + '"]');
                    wrapper.appendChild(clone);
                    submenu.parentNode.removeChild(submenu);
                }
            }
        })
    }

    setupNav();

    moveSubmenus();

    // Main JS Menu script

    var navExpander = document.getElementById('jsNavTrigger');
    var nav = document.getElementById('jsNav');

    if (window.innerWidth < 720) {
        closeJsMenu();
    }

    function openJsMenu() {
        navExpander.setAttribute('aria-expanded', 'true');
        nav.style.display = 'block';
        navExpander.innerHTML = '×';
    }

    function closeJsMenu() {
        navExpander.setAttribute('aria-expanded', 'false');
        nav.style.display = 'none';
        navExpander.innerHTML = '☰';
    }

    navExpander.addEventListener('click', function() {
        var expanded = this.getAttribute('aria-expanded') === 'true';
        expanded = !expanded;
        if (expanded) {
            openJsMenu();
        } else {
            closeJsMenu();
        }
    });

    function dimensionChange() {
        var nav = document.getElementById('jsNav');
        if (window.innerWidth < 720) {
            if (nav.style.display === 'none') {
                closeJsMenu();
            } else {
                openJsMenu();
            }
        } else {
            nav.style.display = 'block';
        }
        moveSubmenus();
    }

    var resizeFunction;

    window.addEventListener('resize', function() {
        clearTimeout(resizeFunction);
        resizeFunction = setTimeout(function() {
            dimensionChange();
        }, 50);
    })

    window.addEventListener('orientationchange', dimensionChange);

    var headings = document.querySelectorAll("h2[id], h3[id], h4[id], h5[id], h6[id]");

    for (var i = 0; i < headings.length; i++) {
        headings[i].innerHTML =
            '<a href="#' + headings[i].id + '">' +
            headings[i].innerText +
            '</a>';
    }

    // Eww, eww, eww, ewwww! Forcing a repaint to get around a really, really odd
    // Safari bug: https://twitter.com/csswizardry/status/897110955448029184
    function ready() {
        var page = document.getElementById('jsPage');
        page.style.color = '#231f21';
    };
    document.addEventListener("DOMContentLoaded", ready);
        // End of Theme NHSLA Nightingale JS

};