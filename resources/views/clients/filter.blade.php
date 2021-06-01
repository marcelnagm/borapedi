<form method="GET">
    <div class="row align-items-center">
        <div class="col-8">
            <h6 class="mb-0">Filtros</h6>
        </div>
        <div class="col-4 text-right">
            <button id="show-hide-filters" class="btn btn-icon btn-1 btn-sm btn-outline-secondary" type="button">
                <span class="btn-inner--icon"><i id="button-filters" class="ni ni-bold-down"></i></span>
            </button>
        </div>
    </div>
    <br/>
    <div class="tab-content orders-filters" style="display: none">
        <div class="row">
            <div class="col-md-6">
                <div class="input-daterange datepicker row align-items-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Compras A partir de </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                </div>
                                <input name="fromDate" class="form-control" placeholder="{{ __('Date from') }}" type="text" <?php
                                if (isset($_GET['fromDate'])) {
                                    echo 'value="' . $_GET['fromDate'] . '"';
                                }
                                ?> >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Compras até</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                </div>
                                <input name="toDate" class="form-control" placeholder="{{ __('Date to') }}" type="text"  <?php
                                if (isset($_GET['toDate'])) {
                                    echo 'value="' . $_GET['toDate'] . '"';
                                }
                                ?>>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="form-control-label">Nome: </label>
                    <input name="name_client" class="form-control" placeholder="Parte do nome" type="text"  <?php
                                if (isset($_GET['name_client'])) {
                                    echo 'value="' . $_GET['name_client'] . '"';
                                }
                                ?>>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 offset-md-6">
        <div class="row">
            @if ($parameters)
            <div class="col-md-4">
                <a href="{{ Request::url() }}" class="btn btn-md btn-block">{{ __('Clear Filters') }}</a>
            </div>
            @else
            <div class="col-md-8"></div>
            @endif

            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-md btn-block">{{ __('Filter') }}</button>
            </div>
        </div>
    </div>
</div>
</form>