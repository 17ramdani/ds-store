<x-app-layout>

    <section id="navbarSecondary" class="uk-flex uk-flex-middle uk-flex-left">
        <div class="uk-width-1-1">
            <div class="uk-container">
                 <div class="uk-flex uk-flex-between uk-flex-middle">
                     <div>
                         <h2 class="rz-text-pagetitle uk-margin-remove">Welcome</h2>
                     </div>
                     <div>
                         <a href="{{ route('register') }}" class="uk-button uk-button-primary uk-button-small uk-border-rounded">Daftar</a>
                     </div>
                 </div>
            </div>
        </div>
    </section>
    <main class="uk-margin-medium">
        <div class="uk-container uk-container-small">
            <div class="rz-panel">
                
               <div class="uk-child-width-1-2@s" uk-grid>
                   <div>
                       <x-alert />
                       <form method="POST" action="{{ route('login') }}">
                        @csrf
                            <h3>Login</h3>
    
                            <div class="uk-margin">
                                <input class="uk-input" type="email" name="email" autofocus placeholder="Email">
                            </div>
    
                            <div class="uk-margin">
                                <input class="uk-input" type="password" name="password" placeholder="Password"
                                autocomplete="current-password">
                            </div>
    
                            
                            <div class="uk-margin">
                                <button type="submit" class="uk-button uk-button-primary uk-border-rounded">Login</button>
                            </div>
    
                        </form>
                   </div>
                   <div>
                       <img src="https://duniasandang.com/wp-content/uploads/2022/06/kartu.png" alt="" class="uk-border-rounded">
                   </div>
               </div>
    
            </div>
        </div>
    </main>
</x-app-layout>
