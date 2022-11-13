    var app = new Vue({
        el: '#app',
        data: {
            message: 'i am nothing',
            experiences: [], // il faut declaer cette variable vide 
            open: false,
            experience:{
                id:0,
                cv_id:window.Laravel.idExperience,
                titre:'',
                body:'',
                debut:'',
                fin:''
            }
        },
        methods:{
            getExperience:function(){
                axios.get(window.Laravel.url+'/getexperience/'+window.Laravel.idExperience)
                .then(response => {
                    this.experiences = response.data;
                })
                .catch(error=>{
                    console.log('errrrrreur',error.response);
                })
            },
            deleteExperience:function(experience){
                            swal({
                              title: 'Are you sure?',
                              text: "You won't be able to revert this!",
                              type: 'warning',
                              showCancelButton: true,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                 axios.delete(window.Laravel.url+'/deleteexperience/'+experience.id)
                                    .then(response => {
                                        if(response.data.etat){
                                            var position=this.experiences.indexOf(experience);
                                            this.experiences.splice(position,1);
                                        }
                                    })
                                    .catch(error=>{
                                        console.log(error)
                                    })
                              if (result.value) {
                                swal(
                                  'Deleted!',
                                  'Your file has been deleted.',
                                  'success'
                                )
                              }
                            })
            },

            addExperience:function(){
                axios.post(window.Laravel.url+'/addexperience/', this.experience)
                .then(response => {
                    if(response.data.etat===true){
                        this.open=false;

                        this.experience.id=response.data.id;
                        this.experiences.unshift(this.experience);

                        this.experience={
                            id:0,
                            cv_id:window.Laravel.idExperience,
                            titre:'',
                            body:'',
                            debut:'',
                            fin:''
                        },
                        edit=false

                    }
                })
                .catch(error=>{
                    console.log(error);
                })
            },
            editExperience:function(experience){
                this.open=true;
                this.edit=true;
                this.experience=experience;
            },
            updateExperience:function(){
                axios.put(window.Laravel.url+'/updateexperience/', this.experience)
                .then(response => {
                    if(response.data.etat){
                        this.open=false;

                        this.experience={
                                            id:0,
                                            cv_id:window.Laravel.idExperience,
                                            titre:'',
                                            body:'',
                                            debut:'',
                                            fin:''
                                        };
                    }
                     this.edit=false;
                })
                .catch(error=>{
                    console.log(error)
                })
            }


         },
         created:function(){
            this.getExperience();
         }
    });