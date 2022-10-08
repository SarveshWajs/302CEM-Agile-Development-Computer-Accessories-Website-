 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"></link>
            <link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet"></link>
            <style>
                .form-control, .form-select, .card, .btn
                {
                    border-radius: 15px;
                }

                

                .form-select
                {
                    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") !important;
                    background-repeat: no-repeat !important;
                    background-position: right 0.75rem center !important;
                    background-size: 16px 12px !important;
                }

                input[type=checkbox], input[type=radio]
                {
                    width: 23px;
                    height: 23px;
                    display: inline-block;
                    top: 0;
                    position: relative;
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    appearance: none;
                    border: 1px solid #ffffff;
                    overflow: hidden;
                }

                input[type=checkbox]
                {
                    border-radius: 3px;
                }

                input[type=radio]
                {
                    border-radius: 100%;
                }

                input[type=checkbox]:checked, input[type=radio]:checked
                {
                    border: none;
                }

                input[type=checkbox]:checked:after, input[type=radio]:checked:after
                {
                    content: "\f00c";
                    font-family: "Font Awesome 5 Pro";
                    font-weight: 900;
                    left: 0;
                    position:absolute;
                    top:0;
                    font-size: 15px;
                    color: #000;
                    background: #ffffff;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                    height: 100%;
                }
            </style>
        
@extends('layouts.app')
@section('content')
<div class="profile-own-bg">
	<div class="personal-header-info">
			<div class="container">
				<div class="row">
					<div class="col-4" align="left">
						<a href="{{ route('profile') }}">
							<p style="color: white;"><i class="fa fa-chevron-left"></i> Back</p>
						</a>
					</div>
					<div class="col-4" align="left">
						<p align="center" class="header-title">Calorie Calculator</p>
					</div>
					<div class="col-4" align="right">
						<a href="{{ route('my_setting') }}" class="setting-btn">
							<i class="fa fa-cog" style="font-size: 20px;"></i>
						</a>
					</div>
				</div>
			</div>
    <div class="container">
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <a href="{{ route('profile') }}">
                            @if(!empty(Auth::user()->profile_logo))
                                <!-- <img src="{{ url(Auth::user()->profile_logo) }}" width="50" class="profile-logo"> -->
                                <div style="background-image: url({{ url(Auth::user()->profile_logo) }}); width: 50px; height: 50px; border-radius: 100%; background-size: 100%; background-position: center; background-repeat: no-repeat;"></div>
                            @else
                                <img src="{{ url('images/images.png') }}" width="50" class="profile-logo">
                            @endif                          
                        </a>
                    </div>
                   <div class="col-6">
                        &nbsp;
                        <b class="profile-name">{{ Auth::user()->f_name }} {{ Auth::user()->l_name }}</b>
                        <br>
                        &nbsp;
                        <small class="profile-code">Code: {{ Auth::user()->code }}</small>
                        
                        
                    </div> 
                    <!-- <div class="col-xs-4" align="right">
                        <a href="#">
                            <i class="fa fa-pencil"></i> Edit Profile
                        </a>

                    </div> -->
                </div>
            </div>
            <br>
            @if(Auth::guard('web')->check())
                <!-- <div class="form-group container-box sl-personal-header">
                    <div class="row">
                        <div class="col-6" align="center">
                            <a href="{{ route('myqrcode') }}">
                                <img src="{{ url('images/qrcode.png') }}" width="30">
                                <br>
                                <span class="profile-word">My QRcode</span>
                            </a>
                        </div>

                        <div class="col-4" align="center">
                            <a href="{{ route('MyAffiliate', Auth::user()->code) }}">
                                <img src="{{ url('images/profile/585e4d1ccb11b227491c339b.png') }}" width="30">
                                <br>
                                <span class="profile-word">My Team</span>
                            </a>
                        </div>

                        <div class="col-6" align="center">
                            <a href="{{ route('wallet') }}">
                                <img src="{{ url('images/profile/c3286d4d32fa90ebcf09b488654612b9-wallet-icon-by-vexels.png') }}" width="30">
                                <br>
                                <span class="profile-word">My Wallet</span>
                            </a>
                        </div>
                    </div>
                </div> -->
            @else
                <div class="form-group container-box sl-personal-header">
                    <div class="row">
                        <div class="col" align="center">
                            <a href="{{ route('myqrcode') }}">
                                <img src="{{ url('images/qrcode.png') }}" width="30">
                                <br>
                                <span class="profile-word">My QRcode</span>
                            </a>
                        </div>

                    

                        <div class="col" align="center">
                            <a href="{{ route('wallet') }}">
                                <img src="{{ url('images/profile/calories.png') }}" width="30">
                                <br>
                                <span class="profile-word">Calorie Calculator</span>
                            </a>
                        </div>

                        
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<br>
<br>
<br>

		<div class="container">
			<div class="form-group">
				<div class="row">
					 <form class="CalculateForm" method="post">
                <div class="card bg-dark text-white">
                    <h4 class="text-center text-danger card-header mb-4">Calorie Calculator</h4>
                    <div class="card-body">
                        <div class="row g-5">
                            <div class="col-sm-4">
                                <div>
                                    <h5>Age*</h5>
                                    <input class="form-control text-end" name="age" required="" type="number" value="25" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div>
                                    <h5>Gender*</h5>
                                    <div class="form-control">
                                        <div class="row">
                                            <div class="col-6 d-flex align-items-center">
                                                <input checked="" id="gender_male" name="gender" required="" type="radio" value="0" />
                                                <label class="ms-2">Male</label>
                                            </div>
                                            <div class="col-6 d-flex align-items-center">
                                                <input id="gender_female" name="gender" required="" type="radio" value="1" />
                                                <label class="ms-2">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div>
                                    <h5>Body Fat*</h5>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control text-end" name="bodyFat" required="" type="number" value="20" />
                                        <span class="btn ms-1 bg-warning">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div>
                                    <h5>Height*</h5>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control text-end" name="height" required="" type="number" value="180" />
                                        <span class="btn ms-1 bg-warning text-nowrap">cm</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div>
                                    <h5>Weight*</h5>
                                    <div class="d-flex align-items-center">
                                        <input class="form-control text-end" name="weight" required="" type="number" value="65" />
                                        <span class="btn ms-1 bg-warning text-nowrap">kg</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h5>Activity*</h5>
                                <select class="form-select" name="activity" required="">
                                    <option value="1">Basal Metabolic Rate (BMR)</option>
                                    <option value="1.2">Sedentary: little or no exercise</option>
                                    <option value="1.375">Light: exercise 1-3 times/week</option>
                                    <option selected="" value="1.465">Moderate: exercise 4-5 times/week</option>
                                    <option value="1.55">Active: daily exercise or intense exercise 3-4 times/week</option>
                                    <option value="1.725">Very Active: intense exercise 6-7 times/week</option>
                                    <option value="1.9">Extra Active: very intense exercise daily, or physical job</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <div>
                                    <h5>Result Unit*</h5>
                                    <div class="form-control">
                                        <div class="row">
                                            <div class="col-6 d-flex align-items-center">
                                                <input checked="" id="unit_calories" name="unit" required="" type="radio" value="Calories" />
                                                <label class="ms-2">Calories</label>
                                            </div>
                                            <div class="col-6 d-flex align-items-center">
                                                <input id="unit_kilo" name="unit" required="" type="radio" value="kilojoules" />
                                                <label class="ms-2">kilojoules</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div>
                                    <h5>BMR estimation formula*</h5>
                                    <div class="row g-3">
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <input checked="" id="Mifflin_St_Jeor" name="formula" required="" type="radio" value="0" />
                                            <label class="ms-2">Mifflin St Jeor</label>
                                        </div>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <input id="Revised_Harris_Benedict" name="formula" required="" type="radio" value="1" />
                                            <label class="ms-2">Revised Harris-Benedict</label>
                                        </div>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <input id="Katch_McArdle" name="formula" required="" type="radio" value="2" />
                                            <label class="ms-2">Katch-McArdle</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ans_calculate"></div>
                    <div class="text-center mt-4 card-footer">
                        <button class="btn btn-success" onclick="calculateCalorie(this)" type="button">
                            <i class="fas fa-calculator me-3"></i>
                            Calculate
                        </button>
                    </div>
                </div>
            </form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('js')
<script type="text/javascript">
                function calculateCalorie(obj)
                {
                    const age = obj.form.age.value;
                    const gender = obj.form.gender.value;
                    const bodyFat = obj.form.bodyFat.value;
                    const height = obj.form.height.value;
                    const weight = obj.form.weight.value;
                    const activity = obj.form.activity.value;
                    const unit = obj.form.unit.value;
                    const formula = obj.form.formula.value;

                    let BMR = '';
                    if(formula == 0) // Mifflin
                    {
                        BMR = Mifflin(gender, age, bodyFat, height, weight);
                    }
                    else if(formula == 1) // Harris
                    {
                        BMR = Harris(gender, age, bodyFat, height, weight);
                    }
                    else if(formula == 2) // Katch
                    {
                        BMR = Katch(bodyFat, weight);
                    }

                    let ret = parseFloat(BMR)*parseFloat(activity);
                    if(unit == 'kilojoules')
                    {
                        ret = (ret*4.1868);
                    }

                    document.querySelector(".ans_calculate").innerHTML = '<div class="container"><h4 class="text-center form-control my-3 text-danger fs-4"><b>You should consume <span class="text-red">'+Math.ceil(ret)+' '+unit+'/day </span> of calorie to maintain your weight.</h4></div></b>';
                }

                function Mifflin(gender, age, bodyFat, height, weight)
                {
                    let BMR = (10*weight) + (6.25*height) - (5*age) + 5;
                    if(gender == 1) // Female
                    {
                        BMR = (10*weight) + (6.25*height) - (5*age) - 161;
                    }

                    return BMR;
                }

                function Harris(gender, age, bodyFat, height, weight)
                {
                    let BMR = (13.397*weight) + (4.799*height) - (5.677*age) + 88.362;
                    if(gender == 1) // Female
                    {
                        BMR = (9.247*weight) + (3.098*height) - (4.330*age) + 447.593;
                    }

                    return BMR;
                }

                function Katch(bodyFat, weight)
                {
                    let BMR = 370 + 21.6*(1 - (bodyFat/100))*weight;

                    return BMR;
                }
            </script>
@endsection