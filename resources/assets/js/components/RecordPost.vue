<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        <form>

                        <p><input v-model="form.company_name" placeholder="company name"></p>
                        <p><input v-model="form.contact_name" placeholder="contact name"></p>
                        <p><input v-model="form.contact_mobile" placeholder="contact mobile"></p>
                        <p><input v-model="form.contact_email" placeholder="contact email"></p>
                        <p><input v-model="form.contact_title" placeholder="contact title"></p>
                        <p><input type="checkbox" v-model="form.is_secret">
                        <label> is secret?</label></p>
                        <p><button type="button" @click="store">Create</button></p>
                        </form>
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
                form: {
                    company_name: 'aaa',
                    contact_name: 'bbb',
                    contact_email: 'ccc',
                    contact_mobile: 'eddd',
                    contact_title: 'effff',
                    is_secret: false,
                    scopes: [],
                    errors: []
                }
            };
        },
        mounted() {
            console.log('Component mounted.');
        },
        methods: {

            /**
             * Create a new personal access token.
             */
            store() {
                this.form.errors = [];
                console.log(this.form);
                axios.post('/api/records', this.form)
                .then(function (response) {
                  console.log(response);
                })
                .catch(function (error) {
                  console.log(error);
                });

            },
        }
    }
</script>
