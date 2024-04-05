<!-- Footer -->
<footer class="text-center text-lg-start bg-light text-muted shadow">
    <!-- Section: Social media -->
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
        <!-- Left -->
        <div class="me-5 d-none d-lg-block">
            <span>Aulabook</span>
        </div>
        <!-- Left -->
    </section>
    <!-- Section: Social media -->
    <!-- Section: Links  -->
    <section class="">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-4 d-flex flex-column align-items-center m-5">
                    @if (auth()->guest() || !(auth()->user()->isRevisor() || auth()->user()->isAdmin()))
                        <p>Lavora con noi</p>
                        <a class="btn btn-warning" href="{{ route('become.revisor') }}">Diventa revisore</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Links  -->
    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2023 Copyright:
        <a class="text-reset fw-bold" href="https://mdbootstrap.com/">Aulabook.com</a>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->
