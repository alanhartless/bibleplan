<?php
//no direct access
defined('_JEXEC') or die('Restricted access');

class bibleplan_esvpentateuchandhistoryofisrael extends bibleplan {
    function getVersion() {
        return '1.0.1';
    }

    function getId() {
        return 'esvpentateuchandhistoryofisrael';
    }

    function getName() {
        return 'Pentateuch and History of Israel';
    }

    function getInfo() {
        $info = "Pentateuch and History of Israel<br /><a target='_new' href='http://www.esv.org/biblereadingplans'>www.esv.org</a>";
        return $info;
    }

    function getData() {
        $data = array(
            1 => 'Genesis 1',
            2 => 'Genesis 2',
            3 => 'Genesis 3',
            4 => 'Genesis 4',
            5 => 'Genesis 5',
            6 => 'Genesis 6',
            7 => 'Genesis 7',
            8 => 'Genesis 8:1-19',
            9 => 'Genesis 8:20-9:19',
            10 => 'Genesis 9:20-10:32',
            11 => 'Genesis 11',
            12 => 'Genesis 12-13:1',
            13 => 'Genesis 13:2-18',
            14 => 'Genesis 14',
            15 => 'Genesis 15',
            16 => 'Genesis 16',
            17 => 'Genesis 17',
            18 => 'Genesis 18:1-15',
            19 => 'Genesis 18:16-33',
            20 => 'Genesis 19',
            21 => 'Genesis 20',
            22 => 'Genesis 21:1-21',
            23 => 'Genesis 21:22-34',
            24 => 'Genesis 22',
            25 => 'Genesis 23',
            26 => 'Genesis 24',
            27 => 'Genesis 25:1-18',
            28 => 'Genesis 25:19-34',
            29 => 'Genesis 26',
            30 => 'Genesis 27:1-40',
            31 => 'Genesis 27:41-28:9',
            32 => 'Genesis 28:10-22',
            33 => 'Genesis 29:1-30',
            34 => 'Genesis 29:31-30:43',
            35 => 'Genesis 31',
            36 => 'Genesis 32',
            37 => 'Genesis 33',
            38 => 'Genesis 34',
            39 => 'Genesis 35',
            40 => 'Genesis 36',
            41 => 'Genesis 37',
            42 => 'Genesis 38',
            43 => 'Genesis 39',
            44 => 'Genesis 40',
            45 => 'Genesis 41:1-36',
            46 => 'Genesis 41:37-57',
            47 => 'Genesis 42',
            48 => 'Genesis 43',
            49 => 'Genesis 44',
            50 => 'Genesis 45',
            51 => 'Genesis 46:1-47:12',
            52 => 'Genesis 47:13-26',
            53 => 'Genesis 47:27-48:22',
            54 => 'Genesis 49',
            55 => 'Genesis 50:1-14',
            56 => 'Genesis 50:15-26',
            57 => 'Exodus 1:1-21',
            58 => 'Exodus 1:22-2:22',
            59 => 'Exodus 2:23-3:22',
            60 => 'Exodus 4',
            61 => 'Exodus 5:1-6:9',
            62 => 'Exodus 6:10-7:13',
            63 => 'Exodus 7:14-8:19',
            64 => 'Exodus 8:20-9:12',
            65 => 'Exodus 9:13-10:29',
            66 => 'Exodus 11:1-12:30',
            67 => 'Exodus 12:31-13:22',
            68 => 'Exodus 14',
            69 => 'Exodus 15:1-21',
            70 => 'Exodus 15:22-16:36',
            71 => 'Exodus 17',
            72 => 'Exodus 18',
            73 => 'Exodus 19',
            74 => 'Exodus 20:1-17',
            75 => 'Exodus 20:18-21:11',
            76 => 'Exodus 21:12-22:15',
            77 => 'Exodus 22:16-23:9',
            78 => 'Exodus 23:10-33',
            79 => 'Exodus 24',
            80 => 'Exodus 25',
            81 => 'Exodus 26',
            82 => 'Exodus 27:1-19',
            83 => 'Exodus 27:20-28:43',
            84 => 'Exodus 29',
            85 => 'Exodus 30-31',
            86 => 'Exodus 32',
            87 => 'Exodus 33',
            88 => 'Exodus 34',
            89 => 'Exodus 35:1-29',
            90 => 'Exodus 35:30-36:38',
            91 => 'Exodus 37',
            92 => 'Exodus 38',
            93 => 'Exodus 39',
            94 => 'Exodus 40',
            95 => 'Leviticus 1',
            96 => 'Leviticus 2',
            97 => 'Leviticus 3',
            98 => 'Leviticus 4:1-5:13',
            99 => 'Leviticus 5:14-6:7',
            100 => 'Leviticus 6:8-7:38',
            101 => 'Leviticus 8',
            102 => 'Leviticus 9',
            103 => 'Leviticus 10',
            104 => 'Leviticus 11',
            105 => 'Leviticus 12',
            106 => 'Leviticus 13',
            107 => 'Leviticus 14:1-32',
            108 => 'Leviticus 14:33-57',
            109 => 'Leviticus 15',
            110 => 'Leviticus 16',
            111 => 'Leviticus 17',
            112 => 'Leviticus 18',
            113 => 'Leviticus 19',
            114 => 'Leviticus 20',
            115 => 'Leviticus 21:1-22:16',
            116 => 'Leviticus 22:17-33',
            117 => 'Leviticus 23',
            118 => 'Leviticus 24',
            119 => 'Leviticus 25',
            120 => 'Leviticus 26',
            121 => 'Leviticus 27',
            122 => 'Numbers 1',
            123 => 'Numbers 2',
            124 => 'Numbers 3-4',
            125 => 'Numbers 5',
            126 => 'Numbers 6',
            127 => 'Numbers 7',
            128 => 'Numbers 8',
            129 => 'Numbers 9:1-14',
            130 => 'Numbers 9:15-10:10',
            131 => 'Numbers 10:11-36',
            132 => 'Numbers 11',
            133 => 'Numbers 12',
            134 => 'Numbers 13-14',
            135 => 'Numbers 15',
            136 => 'Numbers 16-17',
            137 => 'Numbers 18-19',
            138 => 'Numbers 20-21',
            139 => 'Numbers 22',
            140 => 'Numbers 23-24',
            141 => 'Numbers 25',
            142 => 'Numbers 26',
            143 => 'Numbers 27',
            144 => 'Numbers 28-29',
            145 => 'Numbers 30',
            146 => 'Numbers 31',
            147 => 'Numbers 32',
            148 => 'Numbers 33:1-49',
            149 => 'Numbers 33:50-34:29',
            150 => 'Numbers 35-36',
            151 => 'Deuteronomy 1',
            152 => 'Deuteronomy 2',
            153 => 'Deuteronomy 3',
            154 => 'Deuteronomy 4',
            155 => 'Deuteronomy 5',
            156 => 'Deuteronomy 6',
            157 => 'Deuteronomy 7',
            158 => 'Deuteronomy 8:1-9:5',
            159 => 'Deuteronomy 9:6-10:11',
            160 => 'Deuteronomy 10:12-11:32',
            161 => 'Deuteronomy 12',
            162 => 'Deuteronomy 13',
            163 => 'Deuteronomy 14',
            164 => 'Deuteronomy 15:1-18',
            165 => 'Deuteronomy 15:19-16:17',
            166 => 'Deuteronomy 16:18-17:20',
            167 => 'Deuteronomy 18',
            168 => 'Deuteronomy 19',
            169 => 'Deuteronomy 20',
            170 => 'Deuteronomy 21:1-22:12',
            171 => 'Deuteronomy 22:13-30',
            172 => 'Deuteronomy 23:1-14',
            173 => 'Deuteronomy 23:15-25:19',
            174 => 'Deuteronomy 26',
            175 => 'Deuteronomy 27',
            176 => 'Deuteronomy 28:1-14',
            177 => 'Deuteronomy 28:15-68',
            178 => 'Deuteronomy 29:1-30:10',
            179 => 'Deuteronomy 30:11-20',
            180 => 'Deuteronomy 31:1-29',
            181 => 'Deuteronomy 31:30-32:47',
            182 => 'Deuteronomy 32:48-33:29',
            183 => 'Deuteronomy 34',
            184 => 'Joshua 1',
            185 => 'Joshua 2',
            186 => 'Joshua 3',
            187 => 'Joshua 4',
            188 => 'Joshua 5',
            189 => 'Joshua 6',
            190 => 'Joshua 7',
            191 => 'Joshua 8',
            192 => 'Joshua 9',
            193 => 'Joshua 10',
            194 => 'Joshua 11-12',
            195 => 'Joshua 13-14',
            196 => 'Joshua 15',
            197 => 'Joshua 16-17',
            198 => 'Joshua 18-19',
            199 => 'Joshua 20',
            200 => 'Joshua 21',
            201 => 'Joshua 22',
            202 => 'Joshua 23-24',
            203 => 'Judges 1',
            204 => 'Judges 2:1-3:6',
            205 => 'Judges 3:7-31',
            206 => 'Judges 4',
            207 => 'Judges 5',
            208 => 'Judges 6',
            209 => 'Judges 7',
            210 => 'Judges 8',
            211 => 'Judges 9',
            212 => 'Judges 10:1-11:3',
            213 => 'Judges 11:4-40',
            214 => 'Judges 12',
            215 => 'Judges 13',
            216 => 'Judges 14',
            217 => 'Judges 15',
            218 => 'Judges 16',
            219 => 'Judges 17',
            220 => 'Judges 18',
            221 => 'Judges 19',
            222 => 'Judges 20',
            223 => 'Judges 21',
            224 => 'Ruth 1',
            225 => 'Ruth 2',
            226 => 'Ruth 3',
            227 => 'Ruth 4',
            228 => '1Samuel 1:1-2:11',
            229 => '1Samuel 2:12-36',
            230 => '1Samuel 3',
            231 => '1Samuel 4',
            232 => '1Samuel 5:1-7:2',
            233 => '1Samuel 7:3-17',
            234 => '1Samuel 8',
            235 => '1Samuel 9:1-10:16',
            236 => '1Samuel 10:17-11:15',
            237 => '1Samuel 12',
            238 => '1Samuel 13',
            239 => '1Samuel 14',
            240 => '1Samuel 15',
            241 => '1Samuel 16',
            242 => '1Samuel 17',
            243 => '1Samuel 18',
            244 => '1Samuel 19',
            245 => '1Samuel 20',
            246 => '1Samuel 21-22',
            247 => '1Samuel 23-24',
            248 => '1Samuel 25',
            249 => '1Samuel 26',
            250 => '1Samuel 27',
            251 => '1Samuel 28',
            252 => '1Samuel 29-30',
            253 => '1Samuel 31',
            254 => '2Samuel 1',
            255 => '2Samuel 2',
            256 => '2Samuel 3',
            257 => '2Samuel 4',
            258 => '2Samuel 5',
            259 => '2Samuel 6',
            260 => '2Samuel 7',
            261 => '2Samuel 8',
            262 => '2Samuel 9',
            263 => '2Samuel 10',
            264 => '2Samuel 11',
            265 => '2Samuel 12',
            266 => '2Samuel 13',
            267 => '2Samuel 14:1-24',
            268 => '2Samuel 14:25-15:12',
            269 => '2Samuel 15:13-16:14',
            270 => '2Samuel 16:15-17:23',
            271 => '2Samuel 17:24-18:33',
            272 => '2Samuel 19',
            273 => '2Samuel 20',
            274 => '2Samuel 21',
            275 => '2Samuel 22:1-23:7',
            276 => '2Samuel 23:8-39',
            277 => '2Samuel 24',
            278 => '1Kings 1:1-27',
            279 => '1Kings 1:28-53',
            280 => '1Kings 2',
            281 => '1Kings 3',
            282 => '1Kings 4',
            283 => '1Kings 5',
            284 => '1Kings 6',
            285 => '1Kings 7',
            286 => '1Kings 8:1-21',
            287 => '1Kings 8:22-66',
            288 => '1Kings 9:1-9',
            289 => '1Kings 9:10-10:29',
            290 => '1Kings 11',
            291 => '1Kings 12:1-15',
            292 => '1Kings 12:16-33',
            293 => '1Kings 13',
            294 => '1Kings 14:1-20',
            295 => '1Kings 14:21-15:24',
            296 => '1Kings 15:25-16:34',
            297 => '1Kings 17',
            298 => '1Kings 18:1-19',
            299 => '1Kings 18:20-46',
            300 => '1Kings 19',
            301 => '1Kings 20',
            302 => '1Kings 21',
            303 => '1Kings 22:1-40',
            304 => '1Kings 22:41-53',
            305 => '2Kings 1',
            306 => '2Kings 2',
            307 => '2Kings 3',
            308 => '2Kings 4',
            309 => '2Kings 5',
            310 => '2Kings 6:1-23',
            311 => '2Kings 6:24-7:20',
            312 => '2Kings 8',
            313 => '2Kings 9',
            314 => '2Kings 10',
            315 => '2Kings 11',
            316 => '2Kings 12',
            317 => '2Kings 13',
            318 => '2Kings 14:1-22',
            319 => '2Kings 14:23-15:38',
            320 => '2Kings 16',
            321 => '2Kings 17:1-23',
            322 => '2Kings 17:24-41',
            323 => '2Kings 18',
            324 => '2Kings 19',
            325 => '2Kings 20',
            326 => '2Kings 21',
            327 => '2Kings 22',
            328 => '2Kings 23:1-30',
            329 => '2Kings 23:31-24:17',
            330 => '2Kings 24:18-25:21',
            331 => '2Kings 25:22-30',
            332 => 'Job 1',
            333 => 'Job 2',
            334 => 'Job 3',
            335 => 'Job 4-5',
            336 => 'Job 6-7',
            337 => 'Job 8',
            338 => 'Job 9-10',
            339 => 'Job 11',
            340 => 'Job 12',
            341 => 'Job 13',
            342 => 'Job 14',
            343 => 'Job 15',
            344 => 'Job 16-17',
            345 => 'Job 18',
            346 => 'Job 19',
            347 => 'Job 20',
            348 => 'Job 21',
            349 => 'Job 22',
            350 => 'Job 23-24',
            351 => 'Job 25-26',
            352 => 'Job 27',
            353 => 'Job 28',
            354 => 'Job 29',
            355 => 'Job 30',
            356 => 'Job 31',
            357 => 'Job 32',
            358 => 'Job 33',
            359 => 'Job 34-35',
            360 => 'Job 36:1-21',
            361 => 'Job 36:22-37:24',
            362 => 'Job 38',
            363 => 'Job 39:1-40:5',
            364 => 'Job 40:6-42:6',
            365 => 'Job 42:7-17'
        );
        return $data;
    }
}
?>