<template>
    <div class="container">
        <div class="row justify-flex-center pb-4 border-bottom">
            <div class="col-md-5">
                <slot name="header" />
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <slot name="body" />
                    </div>
                    <div class="card-footer">
                        <slot name="footer" />
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</template>