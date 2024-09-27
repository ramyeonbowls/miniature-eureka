document.querySelector('.burger-btn').addEventListener('click', (e) => {
    e.preventDefault()
    e.stopPropagation()
    let navbar = document.querySelector('.main-navbar')

    navbar.classList.toggle('active')
})

document.addEventListener('click', (e) => {
    let navbar = document.querySelector('.main-navbar');
    let burgerBtn = document.querySelector('.burger-btn');

    if (!navbar.contains(e.target) && !burgerBtn.contains(e.target)) {
        navbar.classList.remove('active');
    }
})

window.onload = () => checkWindowSize()
window.addEventListener('resize', (event) => {
    checkWindowSize()
})

function checkWindowSize() {
    if (window.innerWidth < 1200) {
        listener()
    } else {
        listenerLg()
    }
}

function listener() {
    let menuItems = document.querySelectorAll('.menu-item.has-sub')
    menuItems.forEach((menuItem) => {
        menuItem.querySelector('.menu-link').addEventListener('click', (e) => {
            e.preventDefault()
            let submenu = menuItem.querySelector('.submenu')
            submenu.classList.toggle('active')
        })
    })
    
    let submenus = document.querySelectorAll('.submenu-item')
    
    submenus.forEach((submenu) => {
        submenu.querySelector('.submenu-link').addEventListener('click', (e) => {
            let navbar = document.querySelector('.main-navbar');
            if (navbar.classList.contains('active')) {
                navbar.classList.remove('active');
            }
            e.preventDefault()
        })
    })

    let submenuItems = document.querySelectorAll('.submenu-item.has-sub')

    submenuItems.forEach((submenuItem) => {
        submenuItem.querySelector('.submenu-link').addEventListener('click', (e) => {
            e.preventDefault()
            submenuItem.querySelector('.subsubmenu').classList.toggle('active')
        })
    })

    let simpleMenuItems = document.querySelectorAll('.menu-item:not(.has-sub)');
    simpleMenuItems.forEach((simpleMenuItem) => {
        simpleMenuItem.addEventListener('click', () => {
            let navbar = document.querySelector('.main-navbar');
            if (navbar.classList.contains('active')) {
                navbar.classList.remove('active');
            }
        });
    });
}

function listenerLg(){
    document.querySelector('.main-navbar').style.display = ''
    const menuItems = document.querySelectorAll('.menu-item');
    
    menuItems.forEach(item => {
        const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints;
    
        item.addEventListener('click', function() {
            if (window.innerWidth > 1200) {
                const submenu = this.querySelector('.submenu');
    
                if (submenu) {
                    submenu.style.visibility = submenu.style.visibility === 'visible' ? 'hidden' : 'visible';
                    submenu.style.opacity = submenu.style.opacity === '1' ? '0' : '1';
                }
            }
        });
    
        if (!isTouchDevice) {
            item.addEventListener('mouseover', function() {
                const submenu = this.querySelector('.submenu');
                if (submenu) {
                    submenu.style.visibility = 'visible';
                    submenu.style.opacity = '1';
                }
            });
    
            item.addEventListener('mouseout', function() {
                const submenu = this.querySelector('.submenu');
                if (submenu) {
                    submenu.style.visibility = 'hidden';
                    submenu.style.opacity = '0';
                }
            });
        }
    });
}