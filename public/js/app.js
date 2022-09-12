const app = Vue.createApp({
    mounted(){
        this.initiate()
    },
    data(){
        return {
            data:{}
        }
    },
    methods:{
        initiate(){
            new Cakemanager().findAllCake((response)=>{
                this.data = response['data'];
            })
        },
        view(id){
            window.location.href = location.origin+'/view/cake/' + id;
        },
        buy(){
            alert('Item successfully added to your cart :)');
        },
        deleter(id){
            new Cakemanager().deleteCake(id, (response)=>{
                window.location.href = location.origin;
            })
        },
        searcher(){
            $("#search div div").text('Searching');
            new Cakemanager().searchCake({
                'key':'name',
                'search':$("#search input").val()
            }, (response)=>{
                $("#search div div").text('Search');
                if (typeof(response['data']['error']) === 'undefined'){
                    this.data = response['data'];
                }else{
                    alert('No match found');
                }
                
            })
        },
        edit(id){
            window.location.href = location.origin+'/edit/cake/' + id;
        }

    }
})

app.mount('#app');