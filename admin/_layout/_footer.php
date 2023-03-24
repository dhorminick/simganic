<footer class="main-footer">
	<div class="row footer-head">
		<div class="col-12 col-lg-3">
			<h1>LOGO</h1>
		</div>
		<div class="col-12 col-lg-5">
			<div class="form-group">
				<label>SUBSCRIBE TO OUR NEWSLETTER</label>
				<form class="submit-newsletter" method="post" action="submit-newsletter">
				<div class="input-group">
                  	<div class="input-group-prepend">
                    	<div class="input-group-text">
                      		<i class="fas fa-envelope"></i>
                    	</div>
                  	</div>
                  	<input type="email" class="form-control input-newsletter" name="newsletter-email" placeholder="Email">
                  	<div class="input-group-append">
                      	<button class="btn btn-primary btn-newsletter" style="box-shadow:none !important;">SUBMIT</button>
                    </div>
                </div>
                </form>
            </div>
		</div>
		<div class="col-12 col-lg-4" style="display:flex;">
			<div class="whatsapp-tab">
				<a href=""><h1><i class="fa-brands fa-whatsapp"></i></h1></a>
			</div>
			<div class="whatsapp-tab"><a href="">Have an Issue, Click here to chat with us on Whatsapp</a></div>
		</div>
	</div>
	<div class="row footer-body">
		<div class="col-12 col-lg-3 col-md-6 col-footer-link">
			<h6>How To?</h6>
			<ul>
				<li><a href="">Report a Product?</a><br></li>
				<li><a href="">Cancel an Order?</a><br></li>
				<li><a href="">Return a Product?</a><br></li>
				<li><a href="">Shop on SimGanic?</a><br></li>
			</ul>
		</div>
		<div class="col-12 col-lg-2 col-md-6 col-footer-link">
			<h6>Account</h6>
			<ul>
			<?php
                if (!isset($_SESSION['loggedin'])) {
            ?>
				<li><a href="sign-up">Create Account</a><br></li>
				<li><a href="sign-in">Sign In</a><br></li>
				<li><a href="cart">My Cart</a><br></li>
				<li><a href="wishlist">Wishlist</a><br></li>
			</ul>
			<?php }else{?> 
				<li><a href="sign-out">Sign Out</a><br></li>
				<li><a href="cart">My Cart</a><br></li>
				<li><a href="wishlist">Wishlist</a><br></li>
				<li><a href="my-account">Account Settings</a><br></li>
			<?php } ?>
		</div>
		<div class="col-12 col-lg-3 col-md-6 col-footer-link">
			<h6>Meet Us</h6>
			<ul>
				<li><a href="about-simganic">About SimGanic</a><br></li>
				<li><a href="contact-us">Contact Us</a><br></li>
				<li><a href="terms-and-condition">Terms and Conditions</a><br></li>
				<li><a href="privacy-policy">Privacy Policy</a><br></li>
				<li><a href="faqs">FAQ's</a><br></li>
			</ul>
		</div>
		<div class="col-12 col-lg-4 col-md-6 col-footer-link">
			<h6>Transport Offices</h6>
			<ul>
				<li><i class="fa fa-location-dot"></i> 1 Ikede Street, Agboju Amuwo, Lagos, Nigeria.<br></li>
				<li><i class="fa fa-phone"></i> <a href="tel:0800000000">080-0000-0000</a> <div class="bullet"></div> <a href="tel:0800000000">080-0000-0000</a><br></li>
				<li><i class="fa fa-envelope"></i> <a href="mailto:contact@simganic.com">contact@simganic.com</a><br></li>
				<li><i class="fa fa-clock"></i> 10am - 6pm (Mondays to Saturdays)<br></li>
			</ul>
		</div>
		
		<div class="col-12 col-lg-3"></div>
	</div>
	<hr>
    <div class="footer-left fttr-bottom">
        <ul class="social-btns">
            <li><a href="#" title="Whatsapp" class=""><i class="fa-brands fa-whatsapp"></i></a></li>
            <li><a href="#" title="Twitter" class=""><i class="fa-brands fa-twitter"></i></a></li>
            <li><a href="#" title="Facebook" class=""><i class="fa-brands fa-facebook"></i></a></li>
            <li><a href="#" title="Youtube" class=""><i class="fa-brands fa-youtube"></i></a></li>
            <li><a href="#" title="Instagram" class=""><i class="fa-brands fa-instagram"></i></a></li>
        </ul>
    </div>
    <div class="footer-right fttr-bottom">
         <strong>© - 2022</strong> <div class="bullet"></div>  <a href="templateshub.net">Templates Hub</a>
    </div>
    <span id="res"><span id="toastr-20"><span id="toastr-21"><span id="toastr-22"></span>
    <style>
    	.fttr-bottom .social-btns a{
    		font-size: 20px;
    	}
    	.fttr-bottom .social-btns a:hover{
    		font-weight: bolder;
    	}
    </style>
</footer>

<script src="assets/js/script.js"></script>