<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class SeedController extends Controller
{

    public function actionIndex()
    {
        Yii::$app->db->createCommand()->batchInsert(
            'bed_type',
            [
                'name',
                'no_pax',
                'status'
            ],
            [
                ['King Size Bed', 2, 1],
                ['Queen Size Bed', 2, 1],
                ['2 Single Beds', 2, 1],
                ['3 Single Beds', 3, 1],
                ['4 Single Beds', 4, 1],
                ['1 Single Bed', 1, 1],
                ['Twin bed + 1 Extra bed', 3, 1],
                ['Double bed + Extra bed', 3, 1],
                ['2 Single Bed + 1 Double Bed', 4, 1],
                ['Dorm bed', 1, 1],
            ]
        )->execute();

        Yii::$app->db->createCommand()->batchInsert(
            'city',
            [
                'country_id',
                'upload_image_id',
                'code',
                'name',
                'name_kh',
                'description',
                'latitude',
                'longitude',
                'status'
            ],
            [
                [1, '', 'REP', 'Siem Reap', 'សៀមរាប', '', '13.3633', '103.856', 1],
            ]
        )->execute();

        Yii::$app->db->createCommand()->batchInsert(
            'hotel_facility',
            [
                'group_id',
                'name',
                'status',

            ],
            [
                [1, 'Sun terrace', 1],
                [1, 'BBQ facilities', 1],
                [1, 'Balcony', 1],
                [1, 'Terrace', 1],
                [1, 'Garden', 1],
                [2, 'Fax / Photocopying', 1],
                [2, 'Business centre', 1],
                [2, 'Meeting/banquet facilities', 1],
                [2, 'Conference Hall', 1],
                [3, 'Pets are not allowed', 1],
                [4, 'Babysitting Service', 1],
                [4, 'Babysitting / Child Service', 1],
                [4, 'Swimming pool [kids]', 1],
                [4, 'In-room childcare', 1],
                [5, 'Airport transfer', 1],
                [5, 'Library ', 1],
                [5, 'Elevator/lift ', 1],
                [5, '24-hour front desk ', 1],
                [5, 'Porter/bellhop ', 1],
                [5, 'Fitness facilities ', 1],
                [5, 'Free self parking ', 1],
                [5, 'Free valet parking', 1],
                [5, 'Dry cleaning', 1],
                [5, 'Express check-out ', 1],
                [5, 'Outdoor pool', 1],
                [5, 'Free Wi-Fi', 1],
                [5, 'Concierge', 1],
                [5, 'Gift/souvenir shop', 1],
                [5, 'Luggage storage', 1],
                [5, 'Currency exchange', 1],
                [5, 'Laundry service ', 1],
                [5, 'Fitness center', 1],
                [5, '24 hrs Room service', 1],
                [5, 'Ticket services', 1],
                [6, 'Bar', 1],
                [6, 'Poolside Bar', 1],
                [6, 'Snack Bar', 1],
                [6, 'Sky Bar', 1],
                [7, 'Bicycle Rental', 1],
                [7, 'Live Music/Performance', 1],
                [7, 'Cooking Class', 1],
                [7, 'Tour or Class About Local Culture', 1],
                [7, 'Yoga Room', 1],
                [7, 'Horseback Riding', 1],
                [7, 'Happy Hour', 1],
                [7, 'Taxi Service', 1],
                [7, 'Shuttle Service', 1],
                [8, 'English', 1],
                [8, 'Japanese', 1],
                [8, 'Chinese', 1],
                [8, 'Thai', 1],
                [9, 'On-site Coffee Shop', 1],
                [9, 'Bottle of Water', 1],
                [9, 'High-Tea Area', 1],
                [9, 'Fine Dining ', 1],
                [10, 'Golf', 1],
                [10, 'Soccer', 1],
                [10, 'Volley Ball', 1],
                [10, 'Fitness', 1],
                [9, 'Snack Bar', 1],
                [9, 'Breakfast in the Room', 1],
                [9, 'Bar', 1],
                [9, 'Restaurant', 1],
                [9, 'Fruit', 1],
                [9, 'Chocolate/Cookies', 1],
                [1, 'Picnic Area', 1],
                [8, 'French', 1],
                [7, 'Evening Entertainment', 1],
                [7, 'Entertainment Staff', 1],
                [7, 'Library', 1],
                [7, 'Pool Table', 1],
                [7, 'Walking Tours', 1],
                [7, 'Bike Tours', 1],
                [11, 'Swimming Pool', 1],
                [11, 'Fitness/Spa Locker Rooms', 1],
                [11, 'Massage Chair', 1],
                [11, 'Spa/Wellness Packages', 1],
                [11, 'Foot Bath', 1],
                [11, 'Spa Lounge/Relaxation Area', 1],
                [11, 'Steam Room', 1],
                [11, 'Spa Facilities', 1],
                [11, 'Beauty Services', 1],
                [11, 'Pool Towels', 1],
                [11, 'Pool Bar', 1],
                [11, 'Saltwater Pool', 1],
                [11, 'Heated Pool', 1],
                [11, 'Pool With View', 1],
                [11, 'Waterslide', 1],
                [11, 'Open-air Bath', 1],
                [11, 'Fitness Center', 1],
                [5, 'ATM On Site', 1],
                [5, 'Ticket Service', 1],
                [5, 'Currency Exchange', 1],
                [5, 'Private Check-in/Check-out', 1],
                [5, 'Express Check-in/Check-out', 1],
                [5, 'Free Accessible Parking', 1],
                [7, 'Live sport events (broadcast)', 1],
                [7, 'Billiards', 1],
                [7, 'Games room', 1],
                [5, 'Tour Desk', 1],
                [5, 'Car Hire', 1],
                [5, 'Airport Shuttle', 1],
                [5, 'Shared Lounge/ TV Area', 1],
                [7, 'Designated smoking area', 1],
                [8, 'Khmer', 1],
                [12, 'Fire extinguishers', 1],
                [12, 'CCTV outside property', 1],
                [12, 'CCTV in common areas', 1],
                [12, 'Smoke alarm', 1],
                [12, 'Security alarm', 1],
                [12, '24 hrs security', 1],
                [12, 'Safety deposit box', 1],
            ]
        )->execute();

        Yii::$app->db->createCommand()->batchInsert(
            'hotel_facility_group',
            [
                'name',
                'status'
            ],
            [
                ['Outdoors', 1],
                ['Business Facility', 1],
                ['Pets', 1],
                ['Kids Facility', 1],
                ['Services & Extras', 1],
                ['Entertainment', 1],
                ['Activities Available', 1],
                ['Languages Spoken', 1],
                ['Food & Drink', 1],
                ['Sport', 1],
                ['Pool & Spa', 1],
                ['Safety & Security', 1],
                ['Double Room ', 1],
            ]
        )->execute();

        Yii::$app->db->createCommand()->batchInsert(
            'meal',
            [
                'name',

            ],
            [
                ['Breakfast'],
                ['Lunch'],
                ['Dinner'],
                ['Late Night'],

            ]
        )->execute();

        Yii::$app->db->createCommand()->batchInsert(
            'room_amenity',
            [
                'name',
                'status'

            ],
            [
                ['Tea/Coffee maker', 1],
                ['Minibar', 1],
                ['Shower', 1],
                ['Safe', 1],
                ['TV', 1],
                ['Telephone', 1],
                ['Air conditioning', 1],
                ['Hairdryer', 1],
                ['Wake up service/Alarm clock', 1],
                ['Iron', 1],
                ['Kitchenette', 1],
                ['Balcony', 1],
                ['Suit press', 1],
                ['Bathrobe', 1],
                ['Refrigerator', 1],
                ['Desk', 1],
                ['Shared bathroom', 1],
                ['Ironing facilities', 1],
                ['Sitting area', 1],
                ['Free toiletries', 1],
                ['Fan', 1],
                ['Toilet', 1],
                ['Microwave', 1],
                ['Video', 1],
                ['Extra long beds (> 6.5 ft)', 1],
                ['Heating', 1],
                ['Slippers', 1],
                ['Satellite channels', 1],
                ['Kitchen', 1],
                ['Cable channels', 1],
                ['Carpeted', 1],
                ['Guest bathroom', 1],
                ['Interconnecting room(s) available', 1],
                ['Flat-screen TV', 1],
                ['Private entrance', 1],
                ['Sofa', 1],
                ['View', 1],
                ['Hardwood/Parquet floors', 1],
                ['Dining area', 1],
                ['Electric kettle', 1],
                ['Executive Lounge Access', 1],
                ['Kitchenware', 1],
                ['Towels/Sheets (extra fee)', 1],
                ['Dryer', 1],
                ['Wardrobe/Closet', 1],
                ['Garden view', 1],
                ['Pool view', 1],
                ['Cleaning products', 1],
                ['Electric blankets', 1],
                ['Additional bathroom', 1],
                ['Coffee machine', 1],
                ['City view', 1],
                ['Terrace', 1],
                ['Towels', 1],
                ['Linens', 1],
                ['Dining table', 1],
                ['High chair', 1],
                ['Upper floors accessible by elevator', 1],
                ['Clothes rack', 1],
                ['Drying rack for clothinga', 1],
                ['Toilet paper', 1],
                ['Baby safety gates', 1],
                ['Sofa bed', 1],
                ['Daily maid service', 1],
                ['Spa and wellness centre (Additional charge)', 1],
                ['River View', 1],
                ['Ocean View', 1],
                ['Beach View', 1],
                ['Fireplace', 1],
                ['Seating Area', 1],
                ['Safety Deposit Box', 1],
                ['Tile/Marble floor', 1],
                ['Children high chair', 1],
                ['Tumble dryer', 1],
                ['Entire unit located on ground floor', 1],
                ['Entire unit wheelchair accessible', 1],
                ['Socket near the bed', 1],
                ['Non Smoking', 1],
                ['Laptop safe', 1],
                ['Private bathroom', 1],
                ['Free wifi in room', 1],
            ]
        )->execute();

        Yii::$app->db->createCommand()->batchInsert(
            'room_type',
            [
                'name',
                'status'
            ],
            [
                ['Single', 1],
                ['Twin', 1],
                ['Double', 1],
                ['Triple', 1],
                ['Quad', 1],
                ['Dorm Bed', 1],
            ]
        )->execute();

        Yii::$app->db->createCommand()->batchInsert(
            'user_role',
            [
                'name',

            ],
            [
                ['Master Admin'],
                ['Admin'],
                ['Accounting'],
                ['Marketing'],
                ['Operation']

            ]
        )->execute();

        Yii::$app->db->createCommand()->batchInsert(
            'user_role_action',
            [
                'group_id',
                'name',
                'controller',
                'action',
                'status',

            ],
            [
                [1, 'Views', 'vendor', 'index,view', 1],
                [1, 'View Menu', 'menu', 'index,choice-group', 1],
                [1, 'Modify Menu', 'menu', 'add-item,update-item,delete-item', 1],
                [1, 'Modify Table', 'menu', 'add-table,update-table,delete-table', 1],
                [1, 'Modify Package', 'menu', 'add-package,update-package,delete-package', 1],
                [1, 'Modify Category', 'menu', 'add-category,update-category,delete-category', 1],
                [1, 'Modify Choice Group', 'menu', 'add-choice-group,update-choice-group', 1],
                [1, 'Promotion', 'promotion', 'index,create,view', 1],
                [1, 'Report', 'vendor', 'report', 1],
                [1, 'General Setting', 'vendor', 'setting', 1],
                [1, 'Store Setting', 'vendor', 'setting', 1],
                [2, 'View', 'booking', 'index,view', 1],
                [2, 'Manage', 'booking', 'confirm-booking,decline-booking,cancel-booking,change-status', 1],
                [3, 'View', 'promotion-code', 'index', 1],
                [3, 'Manage', 'promotion-code', 'create,view', 1],
                [1, 'View Application', 'vendor', 'application,view-application', 1],
                [1, 'Manage Application', 'vendor', 'decline-application,approve-application', 1],
                [1, 'View Request Promotion', 'vendor', 'promotion,view-promotion', 1],
                [1, 'Manage Promotion', 'vendor', 'decline-promotion,approve-promotion', 1],
                [4, 'View', 'report', 'index', 1],
                [5, 'Allow Reset Password', 'reset-password', 'reset-password', 1],
                [5, 'Manage Amenity', 'amenity', 'index,create,update,delete', 1],
                [5, 'Manage Cancellation', 'cancellation', 'index,create,update,delete', 1],
                [5, 'Manage City', 'city', 'index,create,update,delete', 1],
                [5, 'Manage Zone', 'zone', 'index,create,update,delete', 1],
                [6, 'Manage Promotion Banner', 'promotion-banner', 'index,create,update,delete', 1],
                [7, 'Manage Notification Center', 'notification-center', 'index,create,update,delete,view,template', 1],
                [5, 'Manage Tag', 'tag', 'index,create,update,delete', 1],
            ]
        )->execute();

        return ExitCode::OK;
    }

    public function actionVendorRolePermission()
    {
        Yii::$app->db->createCommand()->batchInsert(
            'user_role_permission',
            [
                'user_role_id',
                'action_id',
            ],
            [
                [1, 1],
                [1, 2],
                [1, 3],
                [1, 4],
                [1, 5],
                [1, 6],
                [1, 7],
                [1, 8],
                [1, 9],
                [1, 10],
                [1, 11],
                [1, 16],
                [1, 17],
                [1, 18],
                [1, 19],
                [1, 12],
                [1, 13],
                [1, 14],
                [1, 15],
                [1, 20],
                [1, 21],
                [1, 22],
                [1, 23],
                [1, 24],
                [1, 25],
                [1, 26],
                [1, 27],
                [2, 1],
                [2, 2],
                [2, 3],
                [2, 4],
                [2, 5],
                [2, 6],
                [2, 7],
                [2, 10],
                [2, 16],
                [2, 17],
                [2, 18],
                [2, 19],
                [2, 12],
                [2, 14],
                [3, 12],
                [3, 14],
                [3, 20],
                [4, 14],
                [4, 15],
                [4, 26],
                [4, 27],
                [5, 1],
                [5, 2],
                [5, 8],
                [5, 9],
                [5, 12],
                [5, 13],
                [5, 20],
                [5, 14],
                [1, 28],
            ]
        )->execute();
    }

    public function actionVendor()
    {
        Yii::$app->db->createCommand()->batchInsert(
            'vendor',
            [
                'type_id',
                'code',
                'logo_id',
                'name',
                'email',
                'phone_number',
                'status',
                'created_at',
                'updated_at',
                'description',
                'rating',
                'reviews',
                'price_range',
            ],
            [
                [1, 'PRO-000001', '', 'PRO Hotel', 'vd_wkle7edcbn@dernham.com', '012345678', 1, '2022-10-12 11:05:45', '2022-10-12 11:08:34', '', '0.00', '0', '$$'],
                [1, 'PRO-000002', '', 'Sovann Angkor II', 'peangsereysothirich@gmail.com', '092321559', 1, '2022-10-26 09:40:53', '2022-11-17 05:13:11', '', '0.00', '0', '$$'],
                [1, 'PRO-000001', '', 'Angkor Holiday', 'vireakthoun24@gmail.com', '060617022', 1, '2022-10-26 09:46:00', '2023-01-14 10:33:45', '', '0.00', '0', '$$'],

            ]
        )->execute();
    }

    public function actionVendorType()
    {
        Yii::$app->db->createCommand()->batchInsert(
            'vendor_type',
            [
                'name',

            ],
            [
                ['Fine Dining'],
                ['Chinese Food'],
                ['Indian Food'],
                ['Buffet'],
                ['Thai Food'],
                ['Western Food'],
                ['Halal Food'],
                ['Vegetarian Food'],
                ['Khmer Food'],
                ['Dinner with Apsara Dance'],
                ['Attraction s place'],
            ]
        )->execute();
    }

    public function actionZone()
    {
        Yii::$app->db->createCommand()->batchInsert(
            'zone',
            [
                'city_id',
                'name',
            ],
            [
                [1, 'ប្រាសាទអង្គរវត្ត - Angkor Wat'],
                [1, 'ភ្នំក្រោម - Phnom Krorm'],
                [1, 'ស្រះស្រង់ - Srah Srang'],
                [1, 'វត្តរាជបូព៌ - Wat Bo'],
                [1, 'បារាយណ៍ខាងលិច - Baray Tek Tla'],
                [1, 'វិទ្យាល័យអង្គរ - Angkor High School'],
                [1, 'បឹងគីឡូ - Boeng Kilo'],
                [1, 'ត្រាវកុដិ - Troav Kot'],
                [1, 'វត្តស្វាយ - Wat Svay'],
                [1, 'វត្តកុងម៉ុច - Wat Kong Moch'],
                [1, 'ផ្លូវជន្លង់ - Jun Lung'],
                [1, 'ផ្សារញ៉ែ - Phsa Nhae'],
                [1, 'ប្រាសាទបាគង - Bakong Temple'],
                [1, 'ផ្លូវលោកតានើយ - Lok Ta Tanery Road'],
                [1, 'ក្រវ៉ាត់ក្រុង៣ - Krovath Krong 3'],
                [1, 'ផ្លូវ៦០ម៉ែត្រ​ - 60m Road'],
                [1, 'ដងស្ទឹង - River side'],
                [1, 'វត្តស្វាយដង្គំ - WatSvay DongKhom']
            ]
        )->execute();
    }

    public function actionUser()
    {
        Yii::$app->db->createCommand()->batchInsert(
            'user',
            [
                'id',
                'role_id',
                'username',
                'auth_key',
                'created_at',
                'updated_at',
                'password_hash',
                'password_reset_token',
                'email',
                'status',
                'is_new',
                'permission_type',
            ],
            [
                ['eea01543-331b-41ae-b8a2-201c3dbea285', 1, 'admin', '-0CND4BU83dmhdGqE71RCOlK4mNxd1PT', '2022-05-02 14:52:43', '2022-06-02 08:00:51', '$2y$13$7edJqUXLuXHllTCpNRIV.OK5.Q6b7RVKsMsLq30Kd//OR2TxSdWbu', '', 'admin@dernham.com', 1, 1, 1,],
                ['eea01543-331b-41ae-b8a2-300s3dbea285', 1, 'master', '-0CND4BU83dmhdGqE71RCOlK4mNxd1PT', '2022-05-02 14:52:43', '2022-06-02 08:00:51', '$2y$13$wzniP5Qax5LzU1SHEsz3TOq70ajdxPh2oE44h6oWJiGx98PPPMVm6', '', 'master@dernham.com', 1, 1, 2,]
            ]
        )->execute();
    }
}
