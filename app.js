window.addEventListener('load',()=>{

    const burger = document.querySelector('#burger')
    const mobile = document.querySelector('#mobile')
    const mobileMenus = document.querySelectorAll('#mobile nav ul li a')

    burger.addEventListener('click',()=>{
        burger.classList.toggle('open-menu')
        mobile.classList.toggle('open-mobile')
    })

    mobileMenus.forEach((menu)=>{
        menu.addEventListener('click',()=>{
            burger.classList.remove('open-menu')
            mobile.classList.remove('open-mobile')
        })
    })




})