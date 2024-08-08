 <!-- Footer Start -->
 <footer data-aos="fade-up" data-aos-duration="1000" data-aos-offset="-100">
     <!-- Call to Action Start -->
     <div class="callto-action-section top-zigzag-bg">
         <div class="container">
             <div class="row align-items-center">
                 <div class="col-md-7 col-lg-8">
                     <h2>We are a Local, Age & Interest Based Activity Discovery Platform.</h2>
                 </div>
                 <div class="col-md-5 col-lg-4 text-md-end position-relative ">
                     <div class="btn-group">
                         <a href="#" class="btn h-black" title="View all Programs">View all Programs</a>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <div class="footer-middle">
         <div class="container">
             <div class="row">
                 <div class="col-sm-12 col-md-12 col-xl-5 col-lg-3">
                     <div class="footer-about">
                         <div class="footer-logo">
                             <a href="index.html" title="Resilient Kidz" rel="home">
                                 <img src="images/logo.png" alt="Resilient Kidz" width="" height="">
                             </a>
                         </div>
                         <p>At Resilient Kids, we strive to give our children the best we possibly can, to ensure their overall growth in social, cognitive, and emotional areas are developed to their fullest potential.</p>
                     </div>
                 </div>
                 <div class="col-sm-12 col-md-12 col-xl-7 col-lg-9 footer-right-block">
                     <div class="footer-block">
                         <h3>Our Programs</h3>
                         <ul>
                             <li><a href="#" title="">Infant Daycare</a></li>
                             <li><a href="#" title="">Toddler Daycare</a></li>
                             <li><a href="#" title="">3-5 Group Daycare</a></li>
                             <li><a href="#" title="">3-5 GrMulti-age Daycare</a></li>
                         </ul>
                     </div>
                     <div class="footer-block">
                         <h3>Quick links</h3>
                         <ul>
                             <li><a href="about.html" title="">About</a></li>
                             <li><a href="programs.html" title="">Programs</a></li>
                             <li><a href="testimonials.html" title="">Testimonials</a></li>
                             <li><a href="contact.html" title="">Contact us</a></li>
                         </ul>
                     </div>
                     <div class="footer-block">
                         <h3>Contact us</h3>
                         <ul class="contact-info">
                             <li><a href="tel:+123-456-5555" title=""><i class="fa-solid fa-phone"></i>Phone: 123-456-5555</a></li>
                             <li><a href="mailto:admin@resilientkidz.com"><i class="fa-solid fa-envelope"></i> admin@resilientkidz.com</a></li>
                         </ul>
                         <div class="social-icon">
                             <ul>
                                 <li><a href="" title=""><i class="fa-brands fa-facebook-f"></i></a></li>
                                 <li><a href="" title=""><i class="fa-brands fa-x-twitter"></i></a></li>
                                 <li><a href="" title=""><i class="fa-brands fa-pinterest-p"></i></a></li>
                                 <li><a href="" title=""><i class="fa-brands fa-linkedin-in"></i></a></li>
                             </ul>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <div class="footer-bottom">
         <div class="container">
             <p>© 2023 Resilient Kidz. All rights reserved</p>
         </div>
     </div>
 </footer>
 <!-- Footer End -->
 </div>
 <!-- Bootstrap Js -->
 <script src="js/jquery-3.7.1.min.js"></script>
 <script src="js/popper.min.js"></script>
 <script src="js/bootstrap.min.js"></script>
 <!-- JavaScript for toggling password visibility -->
 <script>
     function togglePasswordVisibility() {
         var passwordField = document.getElementById("password");
         var eyeIcon = document.getElementById("eye");

         if (passwordField.type === "password") {
             passwordField.type = "text";
             eyeIcon.classList.remove("far", "fa-eye");
             eyeIcon.classList.add("fas", "fa-eye-slash");
         } else {
             passwordField.type = "password";
             eyeIcon.classList.remove("fas", "fa-eye-slash");
             eyeIcon.classList.add("far", "fa-eye");
         }
     }
 </script>

 <!-- Animation Js -->
 <script type="text/javascript" src="js/jquery.easing.js"></script>
 <script type="text/javascript" src="js/aos.js"></script>

 <!-- Menu Js -->
 <script type="text/javascript" src="js/webslidemenu.js"></script>

 <!-- Slider Js -->
 <script type="text/javascript" src="js/slick.min.js"></script>

 <!-- Popus Js -->
 <script type="text/javascript" src="js/magnific-popup.min.js"></script>

 <!-- Script Js -->
 <script type="text/javascript" src="js/main.js"></script>
 </section>
 <!-- Add this script just before the closing </body> tag or in a separate JS file -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
     $(document).ready(function() {
         // Function to apply filter and set active class
         function applyFilter(filterValue) {
             $('#program-flters li').removeClass('filter-active'); // Remove active class from all
             $('[data-filter="' + filterValue + '"]').addClass('filter-active'); // Add active class to the clicked item

             $('.grid-item').hide(); // Hide all items
             if (filterValue === '*') {
                 $('.grid-item').show(); // Show all items
             } else {
                 $(filterValue).show(); // Show items that match the filter
             }
         }

         // On click of filter button
         $('#program-flters li').click(function() {
             var filterValue = $(this).data('filter');
             applyFilter(filterValue);
         });

         // Set default filter to 'All' when page loads
         applyFilter('*');
     });

     $(document).ready(function() {
         // Initially hide the popup
         $(".programs-popup").hide();

         // Event handler for the select program checkboxes
         $(".select-program-btn").change(function() {
             var isChecked = $(this).is(":checked");
             var price = $(this).data("price");

             if (isChecked) {
                 $("#popup-price").text(price);
                 $(".programs-popup").slideDown();
             } else {
                 $(".programs-popup").slideUp();
             }
         });

         // Hide popup when clicking outside of it
         $(document).click(function(event) {
             if (!$(event.target).closest('.programs-popup, .select-program-btn').length) {
                 $(".programs-popup").slideUp();
             }
         });
     });
 </script>
 <script>
     $(document).ready(function() {
         // Check URL parameters
         const urlParams = new URLSearchParams(window.location.search);
         if (urlParams.has('success')) {
             // Show success message
             $('#success-message').fadeIn().delay(2000).fadeOut();

             // Remove the 'success' parameter from the URL
             urlParams.delete('success');
             window.history.replaceState({}, document.title, window.location.pathname + '?' + urlParams.toString());
         }
     });
 </script>
 <script>
     function handleFormSubmit(event) {
         event.preventDefault();
         const form = document.getElementById('categoryForm');
         const formData = new FormData(form);
         fetch(form.action, {
                 method: form.method,
                 body: formData,
             })
             .then(response => response.json())
             .then(data => {
                 if (data.status === 'success') {
                     const tableBody = document.getElementById('categoryTableBody');
                     const newRow = document.createElement('tr');
                     newRow.innerHTML = `
                        <td>${data.id}</td>
                        <td>${data.name}</td>
                        <td>${data.created_at}</td>
                    `;
                     tableBody.prepend(newRow);
                     form.reset();
                 } else {
                     alert('Failed to add category: ' + data.message);
                 }
             })
             .catch(error => console.error('Error:', error));
     }
 </script>
 <!-- Include JavaScript File -->
 <script src="js/comments.js"></script>
 </body>

 </html>