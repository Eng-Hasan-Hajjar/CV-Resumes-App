<template>
<body>
	<div id="innerDownload">
		<button v-on:click="generateReport"> save as  pdf</button>
	</div>
	
	<vue-html2pdf
        :show-layout="true"
        :float-layout="false"
        :enable-download="true"
        :preview-modal="true"
        :paginate-elements-by-height="1400"
        :filename= cv.first_name
        :pdf-quality="2"
        :manual-pagination="false"
        pdf-format="a4"
        pdf-orientation="landscape"
        pdf-content-width="100%"
 
        @progress="onProgress($event)"
        @hasStartedGeneration="hasStartedGeneration()"
        @hasGenerated="hasGenerated($event)"
        ref="html2Pdf"
    >
	<section slot="pdf-content">
		<div id="doc2" v-if="cvDataLoaded" class="yui-t7">
	<div id="inner">
		<div id="hd">
			<div class="yui-gc">
				<div class="image">
					<template v-if="cv.photo">
						<img id="profile-image" class="image"
							v-bind:src="'/storage/'+cv.photo"
							alt="User profile picture"
							style="border: 3px solid; transition: border-radius .3s ease">
					</template>
					<template v-else>
						<img id="profile-image" class="image"
							v-bind:src="'https://img.icons8.com/carbon-copy/100/000000/no-image.png'"
							alt="User profile picture"
							style="border: 3px solid; transition: border-radius .3s ease">
					</template>
                </div>
				<div class="yui-u first">
					<h1>{{ cv.first_name }} {{ cv.last_name }}</h1>
					<h2>{{ cv.profession }}</h2>
				</div>

				<div class="yui-u">
					<div class="contact-info">
						<p>{{ cv.phone }} - {{ cv.email }}</p>
					</div><!--// .contact-info -->
					<div class="contact-info">
						<p>{{ cv.description }}</p>
					</div><!--// .contact-info -->
				</div>
			</div><!--// .yui-gc -->
		</div><!--// hd -->

		<div id="bd">
			<div id="yui-main">
				<div class="yui-b">
					<div v-for="custom_field_categories in cv.custom_field_categories" v-bind:key="custom_field_categories.id">
						<div class="yui-u first">
							<h2>{{custom_field_categories.nama}}</h2>
						</div><!--// .yui-u -->
						<div class="yui-u">
							<div class="cfield" v-for="custom_field_records in custom_field_categories.custom_field_records" v-bind:key="custom_field_records.id">
								<div v-for="(custom_field_record_attribute_line_values,index) in custom_field_records.custom_field_record_attribute_line_values" v-bind:key="custom_field_record_attribute_line_values.id">
									{{custom_field_categories.custom_field_attribute_lines[index].nama}} : {{custom_field_record_attribute_line_values.value}}
								</div>
								<br>
							</div>
						</div>
					</div>
				</div><!--// .yui-b -->
			</div><!--// yui-main -->
		</div><!--// bd -->

		<div id="ft">
			<p>{{ cv.first_name }} {{ cv.last_name }} &mdash; <a :href="'mailto:'+cv.email">{{ cv.email }}</a> &mdash; {{ cv.phone }}</p>
		</div><!--// footer -->

	</div><!-- // inner -->


</div><!--// doc -->
	</section>
</vue-html2pdf>
</body>

</template>

<script>
	import VueHtml2pdf from 'vue-html2pdf';
    export default {
        data(){
            return{
				cv: {},
				cvDataLoaded: false,
                uri: '/public-resource/cv'
            }
        },
        methods: {
            cvInit(){
			
			},
			generateReport () {
            	this.$refs.html2Pdf.generatePdf()
        	},
            putAsyncData(data){
				this.cv = data;
				this.cvDataLoaded = true;
            },
            loadData(){
				var id = window.location.href.split('/').pop();
                axios.get(this.uri + "/" + id)
                .then(response=>{
                    let self = this
                    $.when(this.putAsyncData(response.data.cv)).then(function(){
						self.cvInit();
						console.log(response.data.cv)
						console.log("=======")
						console.log(response.data.cv.custom_field_categories[0])
						console.log("=======")
						console.log(response.data.cv.custom_field_categories[0].custom_field_attribute_lines)
						console.log("=======")
						console.log(response.data.cv.custom_field_categories[0].custom_field_records)
                    });
                });
            },
        },
        mounted() {
            this.loadData();
			console.log('Component mounted.');
        }
    }
</script>
