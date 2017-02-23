<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        <ul id="example-1">
                          <li v-for="item in items">
                            {{ item.name }} - {{ item.addtime_cn }}
                          </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
       data() {
            return {
                items : [],
            };
        },
        mounted() {
            this.index(1);
            console.log('Component mounted.');
        },
        methods: {
            /**
             * Create a new personal access token.
             */
            index(page = 1) {
                axios.get('/api/jobs?page='+page)
                .then(response => {
                  this.items = response.data.data;
                  console.log(response);
                })
                .catch(error => {
                  console.log(error);
                });

            },
        }
    }
</script>
