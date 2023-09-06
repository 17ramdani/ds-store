<main class="uk-margin-medium">
    <div class="uk-container uk-container-small">
        <div class="rz-panel">
            
           <div class="uk-child-width-1-2@s" uk-grid>
               <div>
                    @if (session('status') == 'verification-link-sent')
                        <div class="uk-alert-success" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p>A new verification link has been sent to the email address you provided during registration</p>
                        </div>
                    @endif
                    
                   <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                        <h3>Login</h3>

                        <div class="uk-margin">
                            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.
                        </div>
                        
                        <div class="uk-margin">
                            <button type="submit" class="uk-button uk-button-primary uk-border-rounded">Resend Verification Email</button>
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