@extends('layouts.index')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <div class="row">
                <div class="col-12">
                    <div class="card welcome-banner bg-blue-800">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="p-4">
                                        <h2 class="text-white">Explore Redesigned Able Pro</h2>
                                        <p class="text-white">The Brand new User Interface with power of Bootstrapssss
                                            Components. Explore the Endless possibilities with Able Pro.</p><a
                                            href="https://1.envato.market/zNkqj6"
                                            class="btn btn-outline-light">Exclusive on Themeforest</a>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <div class="img-welcome-banner"><img
                                            src="{{ asset('images/widget/welcome-banner.png') }}" alt="img"
                                            class="img-fluid"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
