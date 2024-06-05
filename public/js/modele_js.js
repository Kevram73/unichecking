document.addEventListener("DOMContentLoaded", function(event) {
   
    const showNavbar = (toggleId, navId, bodyId, headerId) =>{
		const toggle = document.getElementById(toggleId),
		nav = document.getElementById(navId),
		bodypd = document.getElementById(bodyId),
		headerpd = document.getElementById(headerId)
		
		
		
		var showBar = () => {
				// show navbar
				if (nav) 
					nav.classList.toggle('show')
				// change icon
				if (toggle) 
					toggle.classList.toggle('bx-x')
				// add padding to body
				if (bodypd)
					bodypd.classList.toggle('body-pd')
				// add padding to header
				if (headerpd)
					headerpd.classList.toggle('body-pd')
			}
		// Validate that all variables exist
		if(toggle)
			toggle.addEventListener('click', showBar)
		
		showBar()

    }
    
    showNavbar('header-toggle','nav-bar','body-pd','header')
    
    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link')
    
    function colorLink(){
    if(linkColor){
    linkColor.forEach(l=> l.classList.remove('active'))
    this.classList.add('active')
    }
    }
    linkColor.forEach(l=> l.addEventListener('click', colorLink))
    
     // Your code to run since DOM is loaded and ready
    showNavbar('header-toggle','nav-bar','body-pd','header')
    });