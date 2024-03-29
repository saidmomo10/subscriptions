<div class="container">
    <div class="main">
        <div class="main__block">
            @if (session('message'))

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Message success </strong> <br>{{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        
                    </button>
        
                </div>
    
            @endif
    
            @if (session('error'))
        
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Message success </strong> <br>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
        
            @endif
        
            @if ($errors->any())
        
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li><br />
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
        
            @endif

            <div class="crud">
                <form method="POST" action="{{route('activateSubscription', ['id' => $subscription->id])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="btn__form">
                        <button>Activer</button>
                    </div>
                    
                </form> 
                {{ $subscription }}
                @if(isset($key))
                    {{ $key }}
                @endif
            </div>
        </div>
    </div>

    <form method="POST" action="{{route('affectFile', ['id' => $subscription->id])}}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="field mt-4"> 
            @foreach ($availableChannels as $file)
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="file_ids[]" value="{{ $file->id }}">
                    {{ $file->name }}
                </label>
            </div>
        @endforeach
        </div>

        <div class="btn__form">
            <button>Activer</button>
        </div>
    </form>
    {{ $chaine }}
</div>