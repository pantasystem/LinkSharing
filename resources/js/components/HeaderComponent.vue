<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <!--トグル-->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            <a class="nav-link" href="">{{ __('Login') }}</a>
                        </li>

                        <li class="nav-item ">
                            <a class="nav-link d-block d-md-none">mdサイズ以下で表示</a>
                            <a class="nav-link d-none d-md-block" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>

                        <li class="nav-item">
                            
                            

                            <a class="nav-link">
                                <i class="fas fa-bell pull-left" height="100%"></i><span class="nav-link d-md-none d-inline icon-title">通知</span>

                            </a>
                        </li>
                           
                      
                    </ul>
                </div>
            </div>
        </nav>
</template>

<script>
export default {
    props: {
        
    }
}
</script>
<style scoped>
.icon-title{
    margin-left: 0.5em
}
</style>