@extends('layouts.telemed')
@section('title', 'PK-OFFICER || telemedicine')
 
@section('content')

<div class="main-banner" id="top">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6 align-self-center">
              <div class="owl-carousel owl-banner">
                <div class="item header-text">
                  <h6>Welcome to TeleMedicine</h6>
                  <h2>บริการ <em>พบแพทย์</em> <span>ออนไลน์</span></h2>
                  {{-- <p>This is a professional looking HTML Bootstrap 5 website template brought to you by TemplateMo website.</p> --}}
                  <div class="down-buttons">
                    <div class="main-blue-button-hover">
                      <a href="#register">ลงทะเบียน</a>
                    </div>
                    <div class="call-button">
                      <a href="#"><i class="fa fa-phone"></i> 044-861-700</a>
                    </div>
                  </div>
                </div>
                {{-- <div class="item header-text">
                  <h6>Online Marketing</h6>
                  <h2>Get the <em>best ideas</em> for <span>your website</span></h2>
                  <p>You are NOT allowed to redistribute this template ZIP file on any Free CSS collection websites. Contact us for more info. Thank you.</p>
                  <div class="down-buttons">
                    <div class="main-blue-button-hover">
                      <a href="#services">Our Services</a>
                    </div>
                    <div class="call-button">
                      <a href="#"><i class="fa fa-phone"></i> 090-080-0760</a>
                    </div>
                  </div>
                </div> --}}
                {{-- <div class="item header-text">
                  <h6>Video Tutorials</h6>
                  <h2>Watch <em>our videos</em> for your <span>projects</span></h2>
                  <p>Please <a rel="nofollow" href="https://www.paypal.me/templatemo" target="_blank">support us</a> a little via PayPal if this digital marketing HTML template is useful for you. Thank you.</p>
                  <div class="down-buttons">
                    <div class="main-blue-button-hover">
                      <a href="#video">Watch Videos</a>
                    </div>
                    <div class="call-button">
                      <a href="#"><i class="fa fa-phone"></i> 050-040-0320</a>
                    </div>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

 
<div id="register" class="about-us section">
    <div class="container">
        
        <div class="row">
            
            <div class="col-lg-6 align-self-center">
                <div class="left-image">
                    <img src="{{ asset('telemed/assets/images/about-left-image.png') }}" alt="Two Girls working together"> 
                </div>
            </div>
            <div class="col"></div>
            <div class="col-lg-5 align-self-center">
                <h2><em>ลงทะเบียน</em> </h2>
                <p>You can browse free HTML templates on Too CSS website.</p>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="fact-item">
                            <div class="count-area-content">
                                <form id="contact" action="" method="get">
                                    <div class="row">
                                      <div class="col-lg-12">
                                        <fieldset>
                                          <input type="name" name="name" id="name" placeholder="Name" autocomplete="on" required>
                                        </fieldset>
                                      </div>
                                      <div class="col-lg-12">
                                        <fieldset>
                                          <input type="surname" name="surname" id="surname" placeholder="Surname" autocomplete="on" required>
                                        </fieldset>
                                      </div>
                                      <div class="col-lg-12">
                                        <fieldset>
                                          <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your Email" required="">
                                        </fieldset>
                                      </div>
                                      <div class="col-lg-12">
                                        <fieldset>
                                          <input type="text" name="website" id="website" placeholder="Your Website URL" required="">
                                        </fieldset>
                                      </div>
                                      <div class="col-lg-12">
                                        <fieldset>
                                          <button type="submit" id="form-submit" class="main-button">Submit Request</button>
                                        </fieldset>
                                      </div>
                                    </div>
                                  </form>
                                
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</div>
     
 
@endsection
@section('footer')

<script>
    $(document).ready(function() {
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd'
        });
    });
</script>
@endsection
