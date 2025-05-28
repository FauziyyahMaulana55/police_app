@extends('components.master')

@section('content')
    <div class="row">
        <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Police Departement</h5>
                        </div>

                    </div>
                    <!-- Ganti chart dengan foto polisi -->
                    <div class="text-center">
                        <img src="{{ asset('assets/images/logos/police.jpg') }}" alt="Polisi" style="max-width: 100%; height: auto;">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <!-- Vision -->
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4 fw-semibold">Vision</h5>
                            <p>
                                To build a safer, more transparent society by fostering seamless communication and trust between citizens and law enforcement.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Mission -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4 fw-semibold">Mission</h5>
                            <p>
                                To empower citizens and law enforcement through a seamless digital platform that enables real-time reporting, efficient communication, and community collaboration—promoting safety, transparency, and trust across all levels of society.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
