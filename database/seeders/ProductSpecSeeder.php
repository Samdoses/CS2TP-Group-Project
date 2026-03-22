<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductSpecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_specs')->insert([
            //individually adding each spec feature to each product in a many-to-many table

            /*gpus*/

            //4080 rtx gpu
            ['product_id' => 1,'spec_key'=> 'vram', 'spec_value' => '16GB'],
            ['product_id' => 1,'spec_key'=> 'length', 'spec_value' => '304mm'],
            ['product_id' => 1,'spec_key'=> 'power_draw', 'spec_value' => '220W'],

            //4070 Super
            ['product_id'=>23,'spec_key'=>'vram','spec_value'=>'12GB'],
            ['product_id'=>23,'spec_key'=>'length','spec_value'=>'300mm'],
            ['product_id'=>23,'spec_key'=>'power_draw','spec_value'=>'220W'],

            //7900 XT
            ['product_id'=>24,'spec_key'=>'vram','spec_value'=>'20GB'],
            ['product_id'=>24,'spec_key'=>'length','spec_value'=>'330mm'],
            ['product_id'=>24,'spec_key'=>'power_draw','spec_value'=>'300W'],

            //RTX 4060
            ['product_id'=>25,'spec_key'=>'vram','spec_value'=>'8GB'],
            ['product_id'=>25,'spec_key'=>'length','spec_value'=>'250mm'],
            ['product_id'=>25,'spec_key'=>'power_draw','spec_value'=>'115W'],

            /*cpus*/

            //intel cpu
            ['product_id'=>2,'spec_key'=>'socket','spec_value'=>'LGA1700'],
            ['product_id'=>2,'spec_key'=>'cores','spec_value'=>'24'],
            ['product_id'=>2,'spec_key'=>'threads','spec_value'=>'32'],
            ['product_id'=>2,'spec_key'=>'boost_clock','spec_value'=>'6.0GHz'],
            ['product_id'=>2,'spec_key'=>'tdp','spec_value'=>'125W'],

            //rtx 4060
            ['product_id'=>3,'spec_key'=>'socket','spec_value'=>'AM5'],
            ['product_id'=>3,'spec_key'=>'cores','spec_value'=>'16'],
            ['product_id'=>3,'spec_key'=>'threads','spec_value'=>'32'],
            ['product_id'=>3,'spec_key'=>'boost_clock','spec_value'=>'5.7GHz'],
            ['product_id'=>3,'spec_key'=>'tdp','spec_value'=>'170W'],

            //7800x3d
            ['product_id'=>26,'spec_key'=>'socket','spec_value'=>'AM5'],
            ['product_id'=>26,'spec_key'=>'cores','spec_value'=>'8'],
            ['product_id'=>26,'spec_key'=>'threads','spec_value'=>'16'],
            ['product_id'=>26,'spec_key'=>'boost_clock','spec_value'=>'5.0GHz'],
            ['product_id'=>26,'spec_key'=>'tdp','spec_value'=>'120W'],

            //i71400k
            ['product_id'=>27,'spec_key'=>'socket','spec_value'=>'LGA1700'],
            ['product_id'=>27,'spec_key'=>'cores','spec_value'=>'20'],
            ['product_id'=>27,'spec_key'=>'threads','spec_value'=>'28'],
            ['product_id'=>27,'spec_key'=>'boost_clock','spec_value'=>'5.6GHz'],
            ['product_id'=>27,'spec_key'=>'tdp','spec_value'=>'125W'],

            //ryzen
            ['product_id'=>28,'spec_key'=>'socket','spec_value'=>'AM5'],
            ['product_id'=>28,'spec_key'=>'cores','spec_value'=>'6'],
            ['product_id'=>28,'spec_key'=>'threads','spec_value'=>'12'],
            ['product_id'=>28,'spec_key'=>'boost_clock','spec_value'=>'5.3GHz'],
            ['product_id'=>28,'spec_key'=>'tdp','spec_value'=>'105W'],

            /*RAM*/

            //corsair ddr5
            ['product_id'=>4,'spec_key'=>'capacity','spec_value'=>'32GB'],
            ['product_id'=>4,'spec_key'=>'type','spec_value'=>'DDR5'],
            ['product_id'=>4,'spec_key'=>'speed','spec_value'=>'6000MHz'],
            ['product_id'=>4,'spec_key'=>'sticks','spec_value'=>'2'],

            //kingston
            ['product_id'=>29,'spec_key'=>'capacity','spec_value'=>'16GB'],
            ['product_id'=>29,'spec_key'=>'type','spec_value'=>'DDR5'],
            ['product_id'=>29,'spec_key'=>'speed','spec_value'=>'5600MHz'],
            ['product_id'=>29,'spec_key'=>'sticks','spec_value'=>'2'],

            //trident
            ['product_id'=>30,'spec_key'=>'capacity','spec_value'=>'32GB'],
            ['product_id'=>30,'spec_key'=>'type','spec_value'=>'DDR5'],
            ['product_id'=>30,'spec_key'=>'speed','spec_value'=>'6000MHz'],
            ['product_id'=>30,'spec_key'=>'sticks','spec_value'=>'2'],

            //lpx
            ['product_id'=>31,'spec_key'=>'capacity','spec_value'=>'16GB'],
            ['product_id'=>31,'spec_key'=>'type','spec_value'=>'DDR4'],
            ['product_id'=>31,'spec_key'=>'speed','spec_value'=>'3200MHz'],
            ['product_id'=>31,'spec_key'=>'sticks','spec_value'=>'2'],

            /*ssds*/

            //evo plus
            ['product_id'=>5,'spec_key'=>'capacity','spec_value'=>'2TB'],
            ['product_id'=>5,'spec_key'=>'type','spec_value'=>'NVMe'],
            ['product_id'=>5,'spec_key'=>'read_speed','spec_value'=>'3500MB/s'],
            ['product_id'=>5,'spec_key'=>'write_speed','spec_value'=>'3300MB/s'],

            //sn850
            ['product_id'=>32,'spec_key'=>'capacity','spec_value'=>'2TB'],
            ['product_id'=>32,'spec_key'=>'type','spec_value'=>'NVMe Gen4'],
            ['product_id'=>32,'spec_key'=>'read_speed','spec_value'=>'7300MB/s'],
            ['product_id'=>32,'spec_key'=>'write_speed','spec_value'=>'6600MB/s'],

            //p5
            ['product_id'=>33,'spec_key'=>'capacity','spec_value'=>'1TB'],
            ['product_id'=>33,'spec_key'=>'type','spec_value'=>'NVMe Gen4'],
            ['product_id'=>33,'spec_key'=>'read_speed','spec_value'=>'6600MB/s'],
            ['product_id'=>33,'spec_key'=>'write_speed','spec_value'=>'5000MB/s'],

            //990pro
            ['product_id'=>34,'spec_key'=>'capacity','spec_value'=>'1TB'],
            ['product_id'=>34,'spec_key'=>'type','spec_value'=>'NVMe Gen4'],
            ['product_id'=>34,'spec_key'=>'read_speed','spec_value'=>'7450MB/s'],
            ['product_id'=>34,'spec_key'=>'write_speed','spec_value'=>'6900MB/s'],

            /*Motherboard*/
            ['product_id'=>6,'spec_key'=>'socket','spec_value'=>'LGA1700'],
            ['product_id'=>6,'spec_key'=>'chipset','spec_value'=>'Z790'],
            ['product_id'=>6,'spec_key'=>'form_factor','spec_value'=>'ATX'],
            ['product_id'=>6,'spec_key'=>'ram_type','spec_value'=>'DDR5'],
            ['product_id'=>6,'spec_key'=>'ram_slots','spec_value'=>'4'],
            ['product_id'=>6,'spec_key'=>'max_ram','spec_value'=>'192GB'],

            //B650
            ['product_id'=>38,'spec_key'=>'socket','spec_value'=>'AM5'],
            ['product_id'=>38,'spec_key'=>'chipset','spec_value'=>'B650'],
            ['product_id'=>38,'spec_key'=>'form_factor','spec_value'=>'ATX'],
            ['product_id'=>38,'spec_key'=>'ram_type','spec_value'=>'DDR5'],
            ['product_id'=>38,'spec_key'=>'ram_slots','spec_value'=>'4'],
            ['product_id'=>38,'spec_key'=>'max_ram','spec_value'=>'128GB'],

            //Z790p
            ['product_id'=>39,'spec_key'=>'socket','spec_value'=>'LGA1700'],
            ['product_id'=>39,'spec_key'=>'chipset','spec_value'=>'Z790'],
            ['product_id'=>39,'spec_key'=>'form_factor','spec_value'=>'ATX'],
            ['product_id'=>39,'spec_key'=>'ram_type','spec_value'=>'DDR5'],
            ['product_id'=>39,'spec_key'=>'ram_slots','spec_value'=>'4'],
            ['product_id'=>39,'spec_key'=>'max_ram','spec_value'=>'192GB'],

            /*psus*/
            ['product_id'=>7,'spec_key'=>'wattage','spec_value'=>'750W'],
            ['product_id'=>7,'spec_key'=>'rating','spec_value'=>'80+ Gold'],
            ['product_id'=>7,'spec_key'=>'modular','spec_value'=>'Fully Modular'],

            //RM850X
            ['product_id'=>35,'spec_key'=>'wattage','spec_value'=>'850W'],
            ['product_id'=>35,'spec_key'=>'rating','spec_value'=>'80+ Gold'],
            ['product_id'=>35,'spec_key'=>'modular','spec_value'=>'Fully Modular'],

            //evga
            ['product_id'=>36,'spec_key'=>'wattage','spec_value'=>'750W'],
            ['product_id'=>36,'spec_key'=>'rating','spec_value'=>'80+ Gold'],
            ['product_id'=>36,'spec_key'=>'modular','spec_value'=>'Fully Modular'],

            //seasonic
            ['product_id'=>37,'spec_key'=>'wattage','spec_value'=>'650W'],
            ['product_id'=>37,'spec_key'=>'rating','spec_value'=>'80+ Gold'],
            ['product_id'=>37,'spec_key'=>'modular','spec_value'=>'Semi Modular'],

            /*Cases and Coolers*/

            //nh-d15
            ['product_id'=>8,'spec_key'=>'cooler_type','spec_value'=>'Air'],
            ['product_id'=>8,'spec_key'=>'socket_support','spec_value'=>'AM5/LGA1700'],
            ['product_id'=>8,'spec_key'=>'noise_level','spec_value'=>'24dBA'],

            //nzxt h710
            ['product_id'=>9,'spec_key'=>'form_factor_support','spec_value'=>'ATX'],
            ['product_id'=>9,'spec_key'=>'max_gpu_length','spec_value'=>'400mm'],
            ['product_id'=>9,'spec_key'=>'radiator_support','spec_value'=>'360mm'],

            //lancool
            ['product_id'=>40,'spec_key'=>'form_factor_support','spec_value'=>'ATX'],
            ['product_id'=>40,'spec_key'=>'max_gpu_length','spec_value'=>'392mm'],
            ['product_id'=>40,'spec_key'=>'radiator_support','spec_value'=>'360mm'],

            //pop
            ['product_id'=>41,'spec_key'=>'form_factor_support','spec_value'=>'ATX'],
            ['product_id'=>41,'spec_key'=>'max_gpu_length','spec_value'=>'405mm'],
            ['product_id'=>41,'spec_key'=>'radiator_support','spec_value'=>'360mm'],

            /*Fans*/

            //af120
            ['product_id'=>10,'spec_key'=>'fan_size','spec_value'=>'120mm'],
            ['product_id'=>10,'spec_key'=>'rpm','spec_value'=>'1700'],
            ['product_id'=>10,'spec_key'=>'noise','spec_value'=>'25dBA'],

            /*Wi-fi card*/

            //ax20
            ['product_id'=>11,'spec_key'=>'interface','spec_value'=>'PCIe'],
            ['product_id'=>11,'spec_key'=>'wifi_standard','spec_value'=>'WiFi 6'],

            /*operating system ones*/
            //WindowsHome
            ['product_id'=>42,'spec_key'=>'type','spec_value'=>'64-bit'],
            ['product_id'=>42,'spec_key'=>'license','spec_value'=>'OEM'],
            ['product_id'=>42,'spec_key'=>'install_media','spec_value'=>'Digital Key'],

            //WindowsPro
            ['product_id'=>43,'spec_key'=>'type','spec_value'=>'64-bit'],
            ['product_id'=>43,'spec_key'=>'license','spec_value'=>'Retail'],
            ['product_id'=>43,'spec_key'=>'install_media','spec_value'=>'Digital Key'],

            //LinuxMint
            ['product_id'=>44,'spec_key'=>'type','spec_value'=>'64-bit'],
            ['product_id'=>44,'spec_key'=>'license','spec_value'=>'Open Source'],
            ['product_id'=>44,'spec_key'=>'install_media','spec_value'=>'USB'],

            //archusb
            ['product_id'=>45,'spec_key'=>'type','spec_value'=>'64-bit'],
            ['product_id'=>45,'spec_key'=>'license','spec_value'=>'Open Source'],
            ['product_id'=>45,'spec_key'=>'install_media','spec_value'=>'USB'],

            /*Monitors*/

            //oddesy
            ['product_id'=>12,'spec_key'=>'size','spec_value'=>'27 inch'],
            ['product_id'=>12,'spec_key'=>'resolution','spec_value'=>'1440p'],
            ['product_id'=>12,'spec_key'=>'refresh_rate','spec_value'=>'144Hz'],
        ]);
    }
}
