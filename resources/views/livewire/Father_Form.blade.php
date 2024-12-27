@if ($currentStep != 1)
    <div style="display: none" class="row setup-content" id="step-1">
@endif
<div class="col-xs-12">
    <div class="col-md-12">
        <br>
        <div class="form-row">
            <div class="col">
                <label for="title">{{ trans('Parent_trans.Email') }}</label>
                <input type="email" wire:model.blur="email" class="form-control">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <label for="title">{{ trans('Parent_trans.Password') }}</label>
                <input type="password" wire:model="password" class="form-control">
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <br>
        <div class="form-row">
            <div class="col">
                <label for="title">{{ trans('Parent_trans.Name_Father') }}</label>
                <input type="text" wire:model="father_name" class="form-control">
                @error('father_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <label for="title">{{ trans('Parent_trans.Name_Father_en') }}</label>
                <input type="text" wire:model="father_name_en" class="form-control">
                @error('father_name_en')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-3">
                <label for="title">{{ trans('Parent_trans.Job_Father') }}</label>
                <input type="text" wire:model="father_job" class="form-control">
                @error('father_job')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="title">{{ trans('Parent_trans.Job_Father_en') }}</label>
                <input type="text" wire:model="father_job_en" class="form-control">
                @error('father_job_en')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col">
                <label for="title">{{ trans('Parent_trans.National_ID_Father') }}</label>
                <input type="text" wire:model.live="father_national_id" class="form-control">
                @error('father_national_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <label for="title">{{ trans('Parent_trans.Passport_ID_Father') }}</label>
                <input type="text" wire:model.live="father_passport_id" class="form-control">
                @error('father_passport_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col">
                <label for="title">{{ trans('Parent_trans.Phone_Father') }}</label>
                <input type="text" wire:model.live="father_phone" class="form-control">
                @error('father_phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

        </div>


        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">{{ trans('Parent_trans.Nationality_Father_id') }}</label>
                <select class="custom-select my-1 mr-sm-2" wire:model="nationality_father_id">
                    <option selected>{{ trans('Parent_trans.Choose') }}...</option>
                    @foreach ($nationalities as $national)
                        <option value="{{ $national->id }}" wire:key="{{ $national->id }} ">{{ $national->name }}
                        </option>
                    @endforeach
                </select>
                @error('nationality_father_id')
                    <div class="alert alert-danger" wire:key="$loop->index">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col">
                <label for="inputState">{{ trans('Parent_trans.Blood_Type_Father_id') }}</label>
                <select class="custom-select my-1 mr-sm-2" wire:model="blood_type_father_id">
                    <option selected>{{ trans('Parent_trans.Choose') }}...</option>
                    @foreach ($blood_types as $blood_type)
                        <option value="{{ $blood_type->id }} " wire:key="{{ $blood_type->id }}">
                            {{ $blood_type->type }}
                        </option>
                    @endforeach
                </select>
                @error('blood_type_father_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group col">
                <label for="inputZip">{{ trans('Parent_trans.Religion_Father_id') }}</label>
                <select class="custom-select my-1 mr-sm-2" wire:model="religion_father_id">
                    <option selected>{{ trans('Parent_trans.Choose') }}...</option>
                    @foreach ($religions as $religion)
                        <option value="{{ $religion->id }}" wire:key="{{ $religion->id }}">{{ $religion->name }}
                        </option>
                    @endforeach
                </select>
                @error('religion_father_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>


        <div class="form-group">
            <label for="exampleFormControlTextarea1">{{ trans('Parent_trans.Address_Father') }}</label>
            <textarea class="form-control" wire:model="father_address" id="exampleFormControlTextarea1" rows="4"></textarea>
            @error('father_address')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        @if ($updateMode)
            <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" wire:click="firstStepSubmit_edit"
                type="button">{{ trans('Parent_trans.Next') }}
            </button>
        @else
            <button class="btn btn-success btn-sm nextBtn btn-lg pull-right " wire:click="firstStepSubmit"
                type="button">{{ trans('Parent_trans.Next') }}
            </button>
        @endif

    </div>
</div>
</div>
