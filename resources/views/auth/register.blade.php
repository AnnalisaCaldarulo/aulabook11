
<x-layouts.layout>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 class="text-center">
                    Registrati
                </h1>
            </div>
        </div>
    </div>
      
    <div class="container my-5">        
      <div class="row justify-content-center">            
          <div class="col-12 col-md-4">                
              @if ($errors->any())                
                  <div class="alert alert-danger">                    
                      <ul>                        
                          @foreach ($errors->all() as $error)                      
                                <li>{{ $error }}</li>                        
                          @endforeach                    
                      </ul>               
                   </div>                
              @endif                
          <form method="POST" action="{{route('register')}}">                    
                @csrf                   
               {{-- input username --}}                    
                <div class="mb-3">                        
                    <label for="inputName" class="form-label">Nome Utente</label>      
                    <input type="text" name="name" class="form-control">                
                </div>                    
                {{-- input email --}}                    
                <div class="mb-3">                    
                      <label for="InputEmail" class="form-label">Email address</label>  
                      <input type="email" class="form-control" name="email">            
                </div>                    
                {{-- input password --}}                    
                <div class="mb-3">                    
                    <label for="InputPassword1" class="form-label">Password</label>
                     <input type="password" class="form-control" name="password">       
                </div>                    
                {{-- input repeat password --}}                    
                <div class="mb-3">                        
                    <label for="InputConfirmPassword" class="form-label">Conferma Password</label>                        
                    <input type="password" class="form-control" name="password_confirmation">                    
                </div>                    
                <button type="submit" class="btn btn-primary">Submit</button>                
            </form>            
          </div>        
        </div>    
      </div>
  </x-layouts.layout>