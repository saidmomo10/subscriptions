<div class="container">
    <div class="main">
        <div class="main__block">
            <div class="main__title">
                <h2>ADD RENTAL </h2>
                <hr>
            </div>
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
                <form method="POST" action="{{route('createSubscription')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="field">
                        <label for="name">Nom</label>
                        <input  class="form-control" aria-label="default input example" type="text" name="name" value="{{old('name')}}">
                    </div>
                    <div class="field">
                        <label for="duration">Return date</label>
                        <input class="form-control" aria-label="default input example" type="number" name="duration" value="{{old('duration')}}">
                    </div>
                    
                    <div class="btn__form">
                        <button>Save</button>
                    </div>
                    
                </form> 
            </div>
        </div>
    </div>
</div>