<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calculator Binus</title>

    <link type="text/css" rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap-extended.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/styles.css') }}" />
</head>
<body class="bg-light">
<div class="container">
    <div class="card-calculator shadow border-0 my-md-4" id="calculator-wrapper">
        <div class="row">
            <div class="col-sm-8 bg-white">
                <div class="px-2 py-4 px-sm-3 px-xl-4 py-sm-4">
                    <h5>Hitung Nilai UAS</h5>
                    <p class="small text-justify">Untuk menghitung berapa nilai UAS yang harus didapatkan berdasarkan nilai forum, attendance, quiz, PAS dan TAS</p>
                    <div class="row">
                        <div class="col-12 col-md-12 col-xl-10">
                            <div class="mb-3">
                                <h6>Forum</h6>
                                <div class="w-100 text-center" style="font-size: 12px">Minggu</div>
                                <div class="row gx-1 mb-2">
                                    @for($i = 1; $i <= 10; $i++)
                                        <div class="col-3 col-md-2 col-xl-2">
                                            <label for="input-nilai-forum" class="mb-1 small w-100 text-center">{{ $i }}</label>
                                            <input
                                                type="number"
                                                id="input-nilai-forum"
                                                class="form-control form-control-lg"
                                                data-score="forum"
                                            />
                                        </div>
                                    @endfor
                                </div>
                                <small>Masukan jumlah <b><i>Post</i></b> yang sudah diisi setiap minggu dengan melihat di <a href="https://ol.binus.ac.id" target="_blank" tabindex="-1">LMS</a> halaman <i>Score</i></small>
                            </div>
                            <div class="mb-3">
                                <h6>Attendance</h6>
                                <div class="row mb-2">
                                    <div class="col-6 col-sm-4">
                                        <label for="input-nilai-attandance" class="mb-1 small">Kehadiran</label>
                                        <input
                                            type="number"
                                            id="input-nilai-attandance"
                                            class="form-control form-control-lg"
                                            data-score="attendance"
                                            max="100"
                                        />
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <label for="input-total-attandance" class="mb-1 small">Total Kelas</label>
                                        <input
                                            type="number"
                                            id="input-total-attandance"
                                            class="form-control form-control-lg"
                                            data-score="total-attendance"
                                            max="100"
                                            value="6"
                                            onkeydown="return helpers.isNumberKey(event)"
                                        />
                                    </div>
                                </div>
                                <small>Hitung jumlah <b><i>Session Done</i></b> dan <b><i>Total Session</i></b> yang ada di <a href="https://ol.binus.ac.id" target="_blank" tabindex="-1">LMS</a> halaman <i>Attendance</i> dan masukan di <b><i>Kehadiran</i></b> dan <b><i>Total Kelas</i></b></small>
                            </div>
                            <div class="mb-3">
                                <h6>Quiz</h6>
                                <div class="row">
                                    @for($i = 1; $i <= 2; $i++)
                                        <div class="col-6 col-sm-6">
                                            <label for="input-nilai-quiz" class="mb-1 small">Nilai {{ $i }}</label>
                                            <input
                                                type="number"
                                                id="input-nilai-quiz"
                                                class="form-control form-control-lg"
                                                data-score="quiz"
                                                max="100"
                                            />
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="mb-3">
                                <h6>PAS (Personal Assignment)</h6>
                                <div class="row">
                                    @for($i = 1; $i <= 2; $i++)
                                        <div class="col-6 col-sm-6">
                                            <label for="input-nilai-pas" class="mb-1 small">Nilai {{ $i }}</label>
                                            <input
                                                type="number"
                                                id="input-nilai-pas"
                                                class="form-control form-control-lg"
                                                data-score="pas"
                                                max="100"
                                            />
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="mb-3">
                                <h6>TAS (Team Assignment)</h6>
                                <div class="row">
                                    @for($i = 1; $i <= 4; $i++)
                                        <div class="col-6 col-sm-3">
                                            <label for="input-nilai-tas" class="mb-1 small">Nilai {{ $i }}</label>
                                            <input
                                                type="number"
                                                id="input-nilai-tas"
                                                class="form-control form-control-lg"
                                                data-score="tas"
                                                max="100"
                                            />
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 bg-success">
                <div class="py-4 px-md-2 px-1">
                    <h5 class="text-white">Hasil Perhitungan</h5>
                    <p class="small text-white text-justify">Tentukan nilai akhir yang anda inginkan untuk mengetahui berapa nilai UAS yang harus didapatkan</p>
                    <div class="">
                        <div class="mb-3">
                            <label for="input-nilai-akhir" class="mb-1 small text-white">Nilai Akhir</label>
                            <input
                                type="number"
                                id="input-nilai-akhir"
                                class="form-control form-control-lg input-success-dark"
                                data-score="final-score"
                            />
                        </div>
                        <div class="mb-2 text-white d-flex justify-content-between align-items-center" data-label="forum">
                            <div>
                                <div>Nilai Forum</div>
                                <div style="font-weight: 100;font-size: 12px" data-note>100 x 10%</div>
                            </div>
                            <h5 class="mb-0" data-value>10</h5>
                        </div>
                        <div class="mb-2 text-white d-flex justify-content-between align-items-center" data-label="attendance">
                            <div>
                                <div>Nilai Attendance</div>
                                <div style="font-weight: 100;font-size: 12px" data-note>100 x 10%</div>
                            </div>
                            <h5 class="mb-0" data-value>10</h5>
                        </div>
                        <div class="mb-2 text-white d-flex justify-content-between align-items-center" data-label="quiz">
                            <div class="">
                                <div>Nilai Quiz</div>
                                <div style="font-weight: 100;font-size: 12px" data-note>(100 + 100) / 2 x 15%</div>
                            </div>
                            <h5 class="mb-0" data-value>15</h5>
                        </div>
                        <div class="mb-2 text-white d-flex justify-content-between align-items-center" data-label="pas">
                            <div class="">
                                <div>Nilai PAS (Personal Assignment)</div>
                                <div style="font-weight: 100;font-size: 12px" data-note>(100 + 100) / 2 x 20%</div>
                            </div>
                            <h5 class="mb-0" data-value>20</h5>
                        </div>
                        <div class="mb-2 text-white d-flex justify-content-between align-items-center" data-label="tas">
                            <div class="">
                                <div>Nilai TAS (Team Assignment)</div>
                                <div style="font-weight: 100;font-size: 12px" data-note>(100 + 100 + 100 + 100) / 4 x 15%</div>
                            </div>
                            <h5 class="mb-0" data-value>15</h5>
                        </div>
                        <hr class="text-white mb-2">
                        <div class="mb-2 text-white d-flex align-items-center" >
                            <div class="text-end w-75">Total</div>
                            <h5 class="mb-0 w-25 text-end" data-label="total-score">70</h5>
                        </div>
                        <h5 class="text-white">Nilai UAS</h5>
                        <p class="small text-white text-justify">Untuk menentukan nilai UAS yang harus didapatkan dapat menggunakan rumus:</p>
                        <div class="mb-3 text-white" style="font-size: 14px">
                            <div class="d-flex align-items-start mb-2">
                                <span>=</span>
                                <div class="px-1">Nilai Akhir - (Nilai Forum + Nilai Attendance + Nilai Quiz + Nilai PAS + Nilai TAS) / 30%</div>
                            </div>
                        </div>
                        <div data-label="result"></div>
                        <div class="mb-0">
                            <p class="text-white mb-0" style="font-size: 12px" data-label="note-score"></p>
                            <h4 class="mb-0 text-white" data-label="final-score"></h4>
                            <p class="text-white mb-0" style="font-size: 12px" data-label="note-total"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('plugins/jquery/jquery.js') }}"></script>
<script src="{{ asset('js/calculate-exam-score.js') }}"></script>
<script type="text/javascript">
    const calculateExam = new CalculateExamScore('#calculator-wrapper');
    calculateExam.configure();
    calculateExam.render();
</script>
</body>
</html>
