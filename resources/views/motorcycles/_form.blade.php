{{ csrf_field() }}

<div class="row">
    <div class="col-md-7">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" id="title"
                   value="{{ old('title', $motorcycle->title) }}"
                   required autofocus
            >

            @if ($errors->has('title'))
                <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="6"
                      class="form-control"
            >{{ old('description', $motorcycle->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="phoneNumber">Phone Number</label>
            <input type="text" name="phone_number" class="form-control" id="phoneNumber"
                   value="{{ old('phone_number', $motorcycle->phone_number ?: auth()->user()->phone_number) }}"
                   required
            >

            @if ($errors->has('phone_number'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
            @endif
        </div>

        @if($motorcycle->exists)
            <div class="form-group">
                <label class="checkbox-inline">
                    <input type="checkbox" name="sold"> Sold
                </label>
            </div>
        @endif
    </div>
    <div class="col-md-4 col-md-offset-1">
        <div class="images">
            <div class="pull-right">
                <button type="button" class="btn btn-default btn-sm btn-add">
                    <i class="fa fa-plus fa-fw"></i> Add
                </button>
            </div>

            <h2 class="section-title">Images</h2>

            <div class="inputs">
                <div class="file-input">
                    <div class="input-group">
                        <input type="file" name="images[]">
                        <input type="text" class="form-control filename" placeholder="Filename" readonly>
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default btn-select">Select</button>
                            <button type="button" class="btn btn-default btn-delete">
                                <i class="fa fa-trash fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @if(!$motorcycle->media->isEmpty())
                <div class="existing">
                    @foreach($motorcycle->media as $item)
                        @php $title = $motorcycle->title . ' | Image ' . $loop->iteration @endphp

                        <div class="thumb">
                            <button type="button" class="btn btn-danger btn-xs btn-delete" data-id="{{ $item->id }}">
                                <i class="fa fa-trash fa-fw"></i> Delete
                            </button>
                            <a href="{{ $item->getUrl() }}" data-lightbox="images" data-title="{{ $title }}">
                                <img src="{{ $item->getUrl('thumb') }}" alt="{{ $title }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<hr>

<button type="submit" class="btn btn-primary">
    <i class="fa fa-save fa-fw"></i> Submit
</button>

<script id="fileInputTemplate" type="text/x-handlebars-template">
    <div class="file-input">
        <div class="input-group">
            <input type="file" name="images[]">
            <input type="text" class="form-control filename" placeholder="Filename" readonly>
            <div class="input-group-btn">
                <button class="btn btn-default btn-select">Select</button>
                <button class="btn btn-default btn-delete">
                    <i class="fa fa-trash fa-fw"></i>
                </button>
            </div>
        </div>
    </div>
</script>