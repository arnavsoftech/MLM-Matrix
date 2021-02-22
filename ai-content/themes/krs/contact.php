<div class="body-inner">

    <div class="banner-area" id="banner-area" style="background-image:url(<?= theme_url(); ?>images/banner/banner2.jpg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="banner-heading">
                        <h1 class="banner-title">Contact Us</h1>
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li>contact</li>
                        </ol>
                    </div>
                </div>
                <!-- Col end-->
            </div>
            <!-- Row end-->
        </div>
        <!-- Container end-->
    </div>
    <!-- Banner area end-->
    <section class="main-container" id="main-container">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-12">
                    <h2 class="section-title"><span>Send Us Message</span>Contact Us</h2>
                </div>
            </div>
            <!-- Title row end-->
            <div class="row">
                <div class="col-lg-4">
                    <div class="ts-col-inner">
                        <div class="ts-contact-info box-border"><span class="ts-contact-icon float-left"><i class="icon icon-map-marker2"></i></span>
                            <div class="ts-contact-content">
                                <h3 class="ts-contact-title">Find Us</h3>
                                <p>1010 Avenue, NY 90001, USA</p>
                            </div>
                            <!-- Contact content end-->
                        </div>
                        <!-- End Contact info 1-->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ts-col-inner">
                        <div class="ts-contact-info box-border"><span class="ts-contact-icon float-left"><i class="icon icon-phone3"></i></span>
                            <div class="ts-contact-content">
                                <h3 class="ts-contact-title">Call Us</h3>
                                <p>1+(91) 458 654 528</p>
                            </div>
                            <!-- Contact content end-->
                        </div>
                        <!-- End Contact info 1-->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="ts-col-inner">
                        <div class="ts-contact-info box-border"><span class="ts-contact-icon float-left"><i class="icon icon-envelope"></i></span>
                            <div class="ts-contact-content">
                                <h3 class="ts-contact-title">Mail Us</h3>
                                <p>info@example.com</p>
                            </div>
                            <!-- Contact content end-->
                        </div>
                        <!-- End Contact info 1-->
                    </div>
                </div>
            </div>
            <!-- Row End-->
        </div>
        <!-- container end-->
        <div class="gap-60"></div>
        <div class="ts-form" id="ts-form">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6" id="app">
                        <form class="contact-form" id="contact-form" action="#" method="POST">
                            <div v-if="errMsg != null" class="alert alert-danger">{{ errMsg }}</div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control form-name" v-model="username" placeholder="Full Name" type="text">
                                    </div>
                                </div>
                                <!-- Col end-->
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control form-website" v-model="phone" placeholder="Phone no" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control form-email" v-model="email" placeholder="Email" type="email">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <textarea v-model="comment" class="form-control form-message required-field" placeholder="Comments" rows="8"></textarea>
                                    </div>
                                </div>
                                <!-- Col 12 end-->
                            </div>
                            <!-- Form row end-->
                            <div class="text-right">
                                <button v-on:click="sendEmail()" class="btn btn-primary tw-mt-30" type="submit">Send</button>
                            </div>
                        </form>
                        <!-- Form end-->
                    </div>
                    <div class="col-lg-6">
                        <div class="map" id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    var vm = new Vue({
        el: '#app',
        data: {
            username: null,
            phone: null,
            email: null,
            comment: null,
            errMsg: null
        },
        methods: {
            sendEmail: function() {
                if (this.username && this.phone && this.email && this.comment) {
                    this.errMsg = "Sending Email...";
                    let url = ApiUrl + 'email/?username=' + this.username + '&email=' + this.email + '&phone=' + this.phone;
                    url += '&comment=' + this.comment;
                    fetch(url).then(ab => ab.json())
                        .then(resp => {
                            console.log(resp);
                            this.errMsg = resp.message;
                            this.username = this.phone = this.email = this.comment = null;
                        });
                } else {
                    this.errMsg = "Please fill all the fields";
                }
            }
        }
    });
</script>