
    @if ($currentStep != 2)
        <div class="row setup-content {{ $currentStep != 1 ? 'displayNone' : '' }}" id="step-2">
    @endif
    <div class="col-xs-12">
        <div class="col-md-12">
            <br>
            <div class="form-row">
                <div class="col">
                    <label for="title">{{ trans('Parent_trans.Name_Mother') }}</label>
                    <input type="text" wire:model="mother_name" class="form-control">
                    @error('mother_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col">
                    <label for="title">{{ trans('Parent_trans.Name_Mother_en') }}</label>
                    <input type="text" wire:model="mother_name_en" class="form-control">
                    @error('mother_name_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-3">
                    <label for="title">{{ trans('Parent_trans.Job_Mother') }}</label>
                    <input type="text" wire:model="mother_job" class="form-control">
                    @error('mother_job')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="title">{{ trans('Parent_trans.Job_Mother_en') }}</label>
                    <input type="text" wire:model="mother_job_en" class="form-control">
                    @error('mother_job_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col">
                    <label for="title">{{ trans('Parent_trans.National_ID_Mother') }}</label>
                    <input type="text" wire:model.live="mother_national_id" class="form-control">
                    @error('mother_national_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col">
                    <label for="title">{{ trans('Parent_trans.Passport_ID_Mother') }}</label>
                    <input type="text" wire:model.live="mother_passport_id" class="form-control">
                    @error('mother_passport_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col">
                    <label for="title">{{ trans('Parent_trans.Phone_Mother') }}</label>
                    <input type="text"  wire:model.live="mother_phone" class="form-control">
                    @error('mother_phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

            </div>


            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputCity">{{ trans('Parent_trans.Nationality_Father_id') }}</label>
                    <select class="custom-select my-1 mr-sm-2" wire:model="nationality_mother_id">
                        <option selected>{{ trans('Parent_trans.Choose') }}...</option>
                        @foreach ($nationalities as $national)
                            <option value="{{ $national->id }}" wire:key="{{ $national->id }}">{{ $national->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('nationality_mother_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col">
                    <label for="inputState">{{ trans('Parent_trans.Blood_Type_Father_id') }}</label>
                    <select class="custom-select my-1 mr-sm-2" wire:model="blood_type_mother_id">
                        <option selected>{{ trans('Parent_trans.Choose') }}...</option>
                        @foreach ($blood_types as $blood_type)
                            <option value="{{ $blood_type->id }}" wire:key="{{ $blood_type->id }}">
                                {{ $blood_type->type }}
                            </option>
                        @endforeach
                    </select>
                    @error('blood_type_mother_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col">
                    <label for="inputZip">{{ trans('Parent_trans.Religion_Father_id') }}</label>
                    <select class="custom-select my-1 mr-sm-2" wire:model="religion_mother_id">
                        <option selected>{{ trans('Parent_trans.Choose') }}...</option>
                        @foreach ($religions as $religion)
                            <option value="{{ $religion->id }}" wire:key="{{ $religion->id }}">{{ $religion->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('religion_mother_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">{{ trans('Parent_trans.Address_Mother') }}</label>
                <textarea class="form-control" wire:model="mother_address" id="exampleFormControlTextarea1" rows="4"></textarea>
                @error('mother_address')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-danger btn-sm nextBtn btn-lg pull-right" type="button" wire:click="back(1)">
                {{ trans('Parent_trans.Back') }}
            </button>

            @if ($updateMode)
                <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" wire:click="secondStepSubmit_edit"
                    type="button">{{ trans('Parent_trans.Next') }}
                </button>
            @else
                <button class="btn btn-success btn-sm nextBtn btn-lg pull-right " type="button"
                    wire:click="secondStepSubmit">{{ trans('Parent_trans.Next') }}</button>
            @endif

        </div>
    </div>
</div>
</div>

