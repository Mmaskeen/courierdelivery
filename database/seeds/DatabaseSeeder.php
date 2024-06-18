<?php

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $faker =  \Faker\Factory::create();

        User::create([

            'name' => 'employee',
            'email' => 'employee@employee.com',
            'role_id' => 2,
            'password' => bcrypt('123123'),
            'avatar' => 'default.png'
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'role_id' => 1,
            'password' => bcrypt('123123'),
            'avatar' => 'default.png'
        ]);

        Role::create([
            'name' => 'admin'
        ]);
        Role::create([
            'name' => 'employee'
        ]);

//        for ($i=0; $i < 100; $i++) {
//            $order =  \App\Models\Order::create([
//                'name' => $faker->name,
//                'order_taker_id' => rand(1,10),
//                'order_id' => rand(1000,1500),
//                'address' => $faker->address,
//                'product' => 'http://order.management.local/admin/dashboard',
//                'quantity' => rand(11,20),
//                'price' => rand(100,200),
//                'postal_code' => rand(1003,2003),
//                'currency' => $faker->randomElement(['USD', 'Pkr']),
//                'shop_name' => 'xyz',
//                'created_at' => Carbon::now()->subDays(rand(11,20)),
//                'email' => $faker->email,
//                'city' => $faker->randomElement(['Lahore', 'Karachi','Jhelum','Islamabad']),
//                'status' => $faker->randomElement(['Proceeded','Latest','Canceled','Hold Order','Dispatched']),
//            ]);
//
//            \App\Models\OrderNumbers::create([
//                'order_id' => $order->id,
//                'mobile' => $faker->PhoneNumber,
//            ]);
//
//            \App\Models\OrderRemark::create([
//                'order_id' => $order->id,
//                'user_id' => rand(1,10),
//                'remark' => $faker->text,
//            ]);
//        }

        $cities = [
            "Islamabad" , "Ahmed Nager Chatha" ,
            "Ahmadpur East" , "Ali Khan Abad" , "Alipur" , "Arifwala" , "Attock" , "Bhera" ,
            "Bhalwal" , "Bahawalnagar" , "Bahawalpur" , "Bhakkar" , "Burewala" , "Chillianwala" , "Chakwal" , "Chichawatni" ,
            "Chiniot" , "Chishtian" , "Daska" , "Darya Khan" ,
            "Dera Ghazi Khan" , "Dhaular" ,
            "Dina" , "Dinga" , "Dipalpur" ,
            "Faisalabad" , "Fateh Jhang", "Ghakhar Mandi", "Gojra",
            "Gujranwala", "Gujrat", "Gujar Khan", "Hafizabad", "Haroonabad", "Hasilpur", "Haveli", "Lakha", "Jalalpur", "Jattan", "Jampur", "Jaranwala",
            "Jhang", "Jhelum", "Kalabagh", "Karor Lal Esan",
            "Kasur", "Kamalia", "Kamoke", "Khanewal",
            "Khanpur","Kharian", "Khushab", "Kot Adu", "Jauharabad",
            "Lahore", "Lalamusa", "Layyah", "Liaquat Pur", "Lodhran", "Malakwal",
            "Mamoori", "Mailsi", "Mandi Bahauddin", "mian Channu", "Mianwali",
            "Multan", "Murree",
            "Muridke", "Mianwali Bangla", "Muzaffargarh",
            "Narowal", "Okara",
            "Renala Khurd", "Pakpattan",
            "Pattoki", "Pir Mahal",
            "Qaimpur", "Qila Didar Singh", "Rabwah", "Raiwind", "Rajanpur", "Rahim Yar Khan",
            "Rawalpindi", "Sadiqabad", "Safdarabad", "Sahiwal", "Sangla Hill", "Sarai Alamgir",
            "Sargodha", "Shakargarh",
            "Sheikhupura", "Sialkot",
            "Sohawa", "Soianwala",
            "Siranwali", "Talagang", "Taxila", "Toba Tek  Singh",
            "Vehari", "Wah Cantonment",
            "Wazirabad", "Badin", "Bhirkan",
            "Rajo Khanani", "Chak",
            "Dadu", "Digri",
            "Diplo", "Dokri", "Ghotki",
            "Haala", "Hyderabad", "Islamkot", "Jacobabad",
            "Jamshoro","Jungshahi",
            "Kandhkot", "Kandiaro", "Karachi",
            "Kashmore", "Keti Bandar", "Khairpur",
            "Kotri", "Larkana",
            "Matiari", "Mehar",
            "Mirpur Khas",
            "Mithani",
            "Mithi",
            "Mehrabpur",
            "Moro",
            "Nagarparkar",
            "Naudero",
            "Naushahro Feroze",
            "Naushara",
            "Nawabshah",
            "Nazimabad",
            "Qambar",
            "Qasimabad",
            "Ranipur",
            "Ratodero",
            "Rohri",
            "Sakrand",
            "Sanghar",
            "Shahbandar",
            "Shahdadkot",
            "Shahdadpur",
            "Shahpur Chakar",
            "Shikarpaur",
            "Sukkur",
            "Tangwani",
            "Tando Adam Khan",
            "Tando Allahyar",
            "Tando Muhammad Khan",
            "Thatta",
            "Umerkot",
            "Warah",
            "Abbottabad",
            "Adezai",
            "Alpuri",
            "Akora Khattak",
            "Ayubia",
            "Banda Daud Shah",
            "Bannu",
            "Batkhela",
            "Battagram",
            "Birote",
            "Chakdara",
            "Charsadda",
            "Chitral",
            "Daggar",
            "Dargai",
            "Darya Khan",
            "dera Ismail Khan",
            "Doaba",
            "Dir",
            "Drosh",
            "Hangu",
            "Haripur",
            "Karak",
            "Kohat",
            "Kulachi",
            "Lakki Marwat",
            "Latamber",
            "Madyan",
            "Mansehra",
            "Mardan",
            "Mastuj",
            "Mingora",
            "Nowshera",
            "Paharpur",
            "Pabbi",
            "Peshawar",
            "Saidu Sharif",
            "Shorkot",
            "Shewa Adda",
            "Swabi",
            "Swat",
            "Tangi",
            "Tank",
            "Thall",
            "Timergara",
            "Tordher",
            "Awaran",
            "Barkhan",
            "Chagai",
            "Dera Bugti",
            "Gwadar",
            "Harnai",
            "Jafarabad",
            "Jhal Magsi",
            "Kacchi",
            "Kalat",
            "Kech",
            "Kharan",
            "Khuzdar",
            "Killa Abdullah",
            "Killa Saifullah",
            "Kohlu",
            "Lasbela",
            "Lehri",
            "Loralai",
            "Mastung",
            "Musakhel",
            "Nasirabad",
            "Nushki",
            "Panjgur",
            "Pishin valley",
            "Quetta",
            "Sherani",
            "Sibi",
            "Sohbatpur",
            "Washuk",
            "Zhob",
            "Ziarat",
        ];

        foreach ($cities as $city){
            \App\Models\City::create([
                'name' => $city
            ]);
        }
    }

}
