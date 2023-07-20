- laravel new rest-api
- open VSC with command in CMD in correct folder:
 code .
- create db with opening .env and copying name of db  // it not take "-" but use"_"!! 
- open http://127.0.0.1:8000

- php artisan make:model Skill -m   // it create model and migration for it
- add to the migration: 
	$table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
- php artisan migrate
- in app/models/Skill.php and add:
	protected $fillable = ['name','slug']; 

- php artisan make:controller Api/V1/SkillContorller  //creates it in file Api/V1


- create routes\api.php: 
<?php
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\SkillContorller;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function() {
    // Route::apiResource('/skills', [SkillContorller::class, 'index']);
    Route::apiResource('/skills', SkillContorller::class );  
});

- php artisan route:list  /// ith will show routers without erors


- INDEX
    - in SkillController create firt function:

        public function index()
        {
            //dd("preslo");
            //return ("Sklill Index");
            return response()->json("Sklill Index");
        }
    - and try it with postmann get: http://127.0.0.1:8000/api/v1/skills  it will return text "Skill Index";


-CREATE
    - php artisan make:request StoreSkillRequest // and write:
        public function authorize(): bool
        {
            //return false;
            return true;
        }

        /**
         * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
         */

        public function rules(): array
        {
            return [
                'name' => ['required', 'min:3', 'max:20'],
                'slug' => ['required', 'unique:skills,slug']
            ];
        }

    - inside Skill controller write:
        public function store(StoreSkillRequest $request)
        {
            Skill::create($request->validated());
            return response()->json("Skill Created");
        }
    - in postman create new POST: http://127.0.0.1:8000/api/v1/skills  and add headers: 
        Accept - application/json
        Content-Type - application/json
        It will return: {"message":"The name field is required. (and 1 more error)","errors":{"name":["The name field is required."],"slug":["The slug field is required."]}}

    - in postman  go to body-JSON and write: 
        {
            "name": "Laravel",
            "slug": "Laravel"
        }
        // it will return "Skill Created".

- UPDATE
    - postman: PUT: http://127.0.0.1:8000/api/v1/skills/1 
    - in SkillController.php:
        public function update(StoreSkillRequest $request, Skill $skill){
            $skill->update($request->validated());
            return response()->json("Skill Updated ");
        }
    - posman add same headers: Accept - application/json
        Content-Type - application/json
    and write: {
        "name": "Laravel....",
        "slug": "Laravel..."
    }      // and it wil get response: "Skill Updated "
    - in storeSkillRequest change:  'slug' => ['required', 'unique:skills,slug,' . $this->skill->id] // menas it must be uniq but exept this id   // this was not wokring!!
    
    - storeSkillRequest change: 
    use Illuminate\Validation\Rule;
    'slug' => ['required', Rule::unique('skills')->ignore($this->skill) ]
    - in postman it will return "Skill Updated "

-SHOW 1
    public function show(Skill $skill){
            return $skill;
        }
    - GET http://127.0.0.1:8000/api/v1/skills/1 // rerun all skill 1 data from db
    - php artisan make:resource V1\SkillResource
    - in SkillController change: return new SkillResource($skill); // and add: use App\Http\Resources\V1\SkillResource;
    - in SkillResource change:  
        //return parent::toArray($request); with
            return [
                'id' => $this->id,
                'name' => $this->name,  //this can be named as 'skilname'
                'slug' => $this->slug
                //'link' => route('skills.show', $this->slug)
            ];

INDEX 
- in SkillController.php chance inside public function index() change;
	return SkillResource::collection(Skill::all());    //or
        //return SkillResource::collection(Skill::paginate());
	return new SkillCollection(Skill::all());

COLLECTION
- php artisan make:resource V1/SkillCollection  //it will make return in public function index() and write:
	return new SkillCollection(Skill::paginate(1));
	use App\Http\Resources\V1\SkillCollection;

DELETE
- public function destroy(Skill $skill){
        $skill->delete();
        return response()->json("Skill Deleted");
    }
- DELETE: 

31>28 s 


FRONTEND - FRONTEND - FRONTEND - FRONTEND - FRONTEND - FRONTEND - FRONTEND - FRONTEND - 

1.
    - npm init vue@latest
        ? Project name: vue-rest-api
        No
        No
        Add Vue Router for Single Page Aplication YES
        No 
        No
        No 

    - cd vue-rest-api
    - npm install
        - code .  // open project in VSC
    - npm run dev

        {
            Continue in work
                https://www.youtube.com/watch?v=GTiBa9bPCZc
                36:18
            GITHUB
                https://github.com/SkalicaSam/vue-rest-api
        }

        - change server port:
            - in vite.config.js change: 
                export default defineConfig({
                    plugins: [
                        vue(),
                    ],
                    resolve: {
                        alias: {
                        '@': fileURLToPath(new URL('./src', import.meta.url))
                        }
                    },
                    server: {
                        port: 3000,
                    },
                })
2.
    - go to vue-rest-api\src\views\App.vue and change it to this..(Delete: hallo word message , image and all style ) : 
        <script setup>
        import { RouterLink, RouterView } from 'vue-router'
        </script>

        <template>
            <header>
                <div class="wrapper">
                <nav>
                    <RouterLink to="/">Home</RouterLink>
                    <RouterLink to="/about">About</RouterLink>
                </nav>
                </div>
            </header>
        <RouterView />
        </template>

    - Delete all files and folders in components in vue-rest-api\src\components  . But folder component must stay. 

    - Delete file  vue-rest-api\src\views\AboutView.vue

    - open vue-rest-api\src\views\HomeView.vue and Delete:
        import TheWelcome from '../components/TheWelcome.vue'
        delete line : <TheWelcome />
3.
    -vue-rest-api\src\router\index.js change 
            component: () => import('../views/HomeView.vue')

    CHECKPOINT -
    - try http://localhost:3000 if it is working

    - Delete file : vue-rest-api\src\assets\base.css  and Delete file: logo.svg

    - open vue-rest-api\src\assets\main.css and Delete All TEXT inside it. And SAVE it



  TAILWIND    -     TAILWIND    -     TAILWIND    -     TAILWIND    - 
    And we are redy to install TAILWIND
1.
    -open https://tailwindcss.com/docs/guides/vite#vue  ..Chapter 2.. ..Install Tailwind CSS:
        - npm install -D tailwindcss postcss autoprefixer
        - npx tailwindcss init -p
2.
    - Add the paths to all of your template files in your tailwind.config.js file. 
        /** @type {import('tailwindcss').Config} */
        export default {
        content: [
            "./index.html",
            "./src/**/*.{vue,js,ts,jsx,tsx}",
        ],
        theme: {
            extend: {},
        },
        plugins: [],
        }
3.
    - Add the @tailwind directives for each of Tailwind’s layers to your ./src/style.css file. but 
    but today to your ./src/main.css file. 
        @tailwind base;
        @tailwind components;
        @tailwind utilities;

    -Run your build process with npm run dev.
4.
    And it is INSTALLERD now change some css params:
        in App.vue: change to:
        <script setup>
            import { RouterLink, RouterView } from 'vue-router'
        </script>

        <template>
            <header>
                <div class="max-w-7xl mx-auto">
                <nav>
                    <RouterLink to="/">Home</RouterLink>
                    <RouterLink to="/about">About</RouterLink>
                </nav>
                </div>
            </header>
            <main class="max-w-7xl mx-auto min-h-screen"></main>
            <RouterView/>
        </template>
5.
    - In index.html change line to: 
        <div id="app" class="bg-slate-200"></div>
6.
    - in index.js change line to: path: '/skills', 
        //path: '/about',

    

 ROUTING: ROUTING    -   ROUTING -    ROUTING    -    ROUTING    -    ROUTING   ROUTING: ROUTING    -   ROUTING -    ROUTING    -    ROUTING    -    ROUTING     

1.      
    - create folder "skills" in views and files:
        - vue-rest-api\src\views\skills\SkillCreate.vue
                        \SkillEdit.vue
                        \SkillIndex.vue
2.
    - in src\router\index.js change: 
    name: 'about', to  name: 'SkillIndex',
        component: () => import('../views/HomeView.vue')
    to 
        component: () => import('../views/skills/SkillIndex.vue')

    skills
3.
    - than in that file copy 3x:
    {
        path: '/skills',
        name: 'SkillIndex',
        component: () => import('../views/skills/SkillIndex.vue')
        }
4.
    and rename it to:
        routes: [
        {
        path: '/',
        name: 'home',
        component: HomeView
        },
        {
        path: '/skills',
        name: 'SkillIndex',
        component: () => import('../views/skills/SkillIndex.vue')
        },
        {
        path: '/skills/create',
        name: 'SkillCreate',
        component: () => import('../views/skills/SkillCreate.vue')
        },
        {
        path: '/skills/:id/edit',
        name: 'SkillEdit',
        component: () => import('../views/skills/SkillEdit.vue')
        }

    ]
5.
    - in app.vue change:         <RouterLink to="/about">About</RouterLink>
        to this: 
        <RouterLink to="/skills">Skills</RouterLink>
6.
    - add some tailwind classes to App.vue:
            <script setup>
        import { RouterLink, RouterView } from 'vue-router'
        </script>

        <template>
        <header>

            <div class="max-w-7xl mx-auto">

            <nav class="p-2">
                <RouterLink
                class="px-4 py-2 mr-4 bg-indigo-600 hover:bg-indigo-800 rounded text-white"
                to="/">Home</RouterLink>
                <RouterLink
                class="px-4 py-2 mr-4 bg-indigo-600 hover:bg-indigo-800 rounded text-white"
                to="/skills">Skills</RouterLink>
            </nav>
            </div>
        </header>

    <main class="max-w-7xl mx-auto min-h-screen"></main>
    <RouterView/>
    </template>

7.
    - write this to SkillIndex, SkillEdit and SkillCreate:
    <script setup>
    </script>
    <template></template>
8.
    - Create in src\composables\skills.js file and folder..
    - npm install axios
    - and write this: 
    import { ref } from "vue"
    import axios from "axios"
    import { useRouter } from "vue-router"

    axios.defaults.baseURL = "http://127.0.0.1:8000/api/v1/";

    export default function useSkills() {
        const skills = ref([])
        const skill = ref([])
        const errors = ref([])
        const router = useRouter()

        const getSkills = async () => {
            
            let response = await axios.get("skills")
            //const response = await axios.get("skills");

            skills.value = response.data.data
        }

        const getSkill = async (id) => {
            await axios.get("skills" + id);
            skill.value = response.data.data;
        }

        const storeSkill = async (data) => {
            try{
                await axios.post("skills", data);
                await router.push({name: "SkillIndex"});
            } catch(error){
                if (error.response.status === 422) {
                    errors.value = error.response.data.errors;
                } 
            }
        }
        
        const updateSkill = async (id) => {
            try{
                await axios.put("skills/" + id, skill.value);
                await router.push({name: "SkillIndex"});

            } catch(error){
                if (error.response.status === 422) {
                    errors.value = error.response.data.errors;
                } 
            }
        }

        const destroySkill = async(id)=>{
            if(!window.confirm("Are You Sure?")){
                return;
            }
            await axios.delete("skills/" + id);
            await getSkills();
        }

        return{
            skill,
            skills,
            getSkill,
            getSkills,
            storeSkill,
            updateSkill,
            destroySkill,
            errors
        }
    }

    -------------------------------------------------------------------------------------------
    TABLE CREATING IN SkillIndex.vue:
1.
    - go to https://flowbite.com/docs/components/tables/ and copy html table.
    - paste that table to SkillIndex.vue. into <template><div class="mt-12">Table</div></template>

    1.03
    -------------------------------------------------------------------------------------------------------
    1.05
    - go to Skillindex.vue and change name in the table... and change all inside template
    <template>
        <div class="mt-200">

            <div class="flex justify-end m-2 p-2">
                <RouterLink :to="{name: 'SkillCreate'}" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded">New Skill</RouterLink>
            </div>
                
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Slug
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Actions
                            </th>
                            <!-- <th scope="col" class="px-6 py-3">
                                Price
                            </th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="skill in skills" :key="skill.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            // <!-- <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            //     Apple MacBook Pro 17"
                            // </th> -->
                            <td class="px-6 py-4">
                                {{ skill.name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ skill.slug }}
                            </td>
                            <td class="px-6 py-4">
                                Edit/Delete
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </template>

    -------------------------------------------------------------------------------------------
  INPUT CREATING IN SkillCreate.vue:
1.
    - SkillCreate.vue:
    - go to https://flowbite.com/docs/forms/input-field/   and copy: Defaul Input
    <div class="mb-6">
        <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Default input</label>
        <input type="text" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    </div>
    - In SkillCreate.vue:
    <script setup>
    import { reactive } from 'vue';
    import useSkills from '../../composables/skills';

    const { storeSkill, errors } = useSkills();

    const form = reactive({
        name: "",
        slug: "",
    })
    </script>

    <template>
        <div class="mt-12">
            <form class="max-w-md mx-auto p-4 bg-white shadow-md rounded-md" @submit.prevent="storeSkill(form)">
                <div class="space-y-6">
                    <div class="mb-6">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Name</label>
                        <input type="text" id="name" v-model="form.name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        <div v-if="errors.name">
                            <span class="text-sm text-red-400">{{ errors.name[0] }}</span>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="mb-6">
                        <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Slug</label>
                        <input type="text" id="slug" v-model="form.slug"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                            focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <div v-if="errors.slug">
                            <span class="text-sm text-red-400">{{ errors.slug[0] }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded">Store</button>
                </div>
            </form>
        </div>
    </template>
   
    BUTTONS 
1.
    - add buttons to the SkillIndex.vue  :
        <td class="px-6 py-4 space-x-2">
                        <!-- Edit/Delete -->
                        <RouterLink 
                        :to="{ name: 'SkillEdit', params: { id: skill.id } }"
                        class="px-4 py-2 bg-green-500 hover:bg-green-700 text-white rounded"
                        >Edit</RouterLink>
                        <button
                        class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded"
                        >Delete</button>
        </td>

    -----------------------------------------------------------------------------
    EDIT FUNCTION
1.
    - in SkillEdit.vue copy all div inside template from SkillCreate.vue
    - in src/router/index.js add "props: true," . So one route will look like:
    {
        path: '/skills/:id/edit',
        name: 'SkillEdit',
        component: () => import('../views/skills/SkillEdit.vue'),
        props: true,
    },
2.
    - so SkillEdit.vue will look like:
    <script setup>
        import useSkills from '../../composables/skills';
        import { onMounted } from 'vue';

        const { skill, getSkill, updateSkill, errors } = useSkills();

        const props = defineProps({
            id: {
                required: true, 
                type: String,
            },
        });

        onMounted(() => getSkill(props.id));
        
    </script>
    <template>
        <div class="mt-12">
            <form class="max-w-md mx-auto p-4 bg-white shadow-md rounded-md" @submit.prevent="updateSkill($route.params.id)">
                <div class="space-y-6">
                    <div class="mb-6">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Name</label>
                        <input type="text" id="name" v-model="skill.name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        <div v-if="errors.name">
                            <span class="text-sm text-red-400">{{ errors.name[0] }}</span>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="mb-6">
                        <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Slug</label>
                        <input type="text" id="slug" v-model="skill.slug"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <div v-if="errors.slug">
                            <span class="text-sm text-red-400">{{ errors.slug[0] }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded">Store</button>
                </div>
            </form>
        </div>
    </template>


    Test if it works 

    ---------------------------------------------------------------------------------------------------
    DESTROY
1.    
    -first import destroySkill inside Skillindex.vue:
    const { skills, getSkills, destroySkill } = useSkills();


    https://www.youtube.com/watch?v=GTiBa9bPCZc
    1.27.37
    -add button aciton @click="" in SkillIndex.vue :

    <button
                                @click="destroySkill(skill.id)"
                                class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded">Delete</button>

-----------------------------------------------------------------------------
And its all
Now test it 
and change naming of butto in SkillEdit.vue From Store to Update.


https://www.youtube.com/watch?v=GTiBa9bPCZc


