<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => ':attributeต้องไม่ต่ำกว่า :min และต้องมากกว่า :max ตัวอักษร',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => ':attributeไม่ตรงกัน',
    'current_password' => 'รหัสผ่านไม่ถูกต้อง',
    'date' => ':attributeไม่ถูกต้อง',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'รูปแบบ:attributeไม่ถูกต้อง',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'ต้องเป็นไฟล์:attribute',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'ต้องเป็นรูปภาพ:attribute',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => ':attribute must not be greater than :max.',
        'file' => ':attribute ต้องมีขนาดไม่เกิน :max กิโลไบต์',
        'string' => ':attribute ต้องไม่มากกว่า :max ตัวอักษร',
        'array' => 'The :attribute must not have more than :max items.',
    ],
    'mimes' => ':attribute ต้องมีนามสกุลไฟล์เป็น :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => ':attributeต้องไม่ต่ำกว่า :min ตัวอักษร',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'กรุณาใส่:attribute',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'กรุณาใส่:attribute',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => ':attributeไม่พร้อมใช้งานหรือมีผู้ใช้อีเมลนี้อยู่แล้ว',
    'uploaded' => 'ไม่สามารถอัพโหลด :attribute ได้',
    'url' => 'The :attribute must be a valid URL.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'email' => 'อีเมล',
        'password' => 'รหัสผ่าน',
        'prefix' => 'คำนำหน้า',
        'fullname' => 'ชื่อ - สกุล',
        'sex' => 'เพศ',
        'phone' => 'เบอร์โทร',
        'institution' => 'สังกัด/หน่วยงาน',
        'address' => 'ที่อยู่',
        'position_id' => 'ตำแหน่งการเข้าร่วม',
        'kota_id' => 'โควต้าเจ้าภาพร่วม',
        'person_attend' => 'ชนิดการเข้าร่วม',
        'topic_th' => 'ชื่อบทความ (ภาษาไทย)',
        'topic_en' => 'ชื่อบทความ (ภาษาอังกฤษ)',
        'presenters.0' => 'ชื่อนักวิจัยคนที่ 1',
        'presenters.1' => 'ชื่อนักวิจัยคนที่ 2',
        'presenters.2' => 'ชื่อนักวิจัยคนที่ 3',
        'presenters.3' => 'ชื่อนักวิจัยคนที่ 4',
        'presenters.4' => 'ชื่อนักวิจัยคนที่ 5',
        'presenters.5' => 'ชื่อนักวิจัยคนที่ 6',
        'presenters.6' => 'ชื่อนักวิจัยคนที่ 7',
        'presenters.7' => 'ชื่อนักวิจัยคนที่ 8',
        'presenters.8' => 'ชื่อนักวิจัยคนที่ 9',
        'presenters.9' => 'ชื่อนักวิจัยคนที่ 10',
        'prefixs.0' => 'คำนำหน้าคนที่ 1',
        'prefixs.1' => 'คำนำหน้าคนที่ 2',
        'prefixs.2' => 'คำนำหน้าคนที่ 3',
        'prefixs.3' => 'คำนำหน้าคนที่ 4',
        'prefixs.4' => 'คำนำหน้าคนที่ 5',
        'prefixs.5' => 'คำนำหน้าคนที่ 6',
        'prefixs.6' => 'คำนำหน้าคนที่ 7',
        'prefixs.7' => 'คำนำหน้าคนที่ 8',
        'prefixs.8' => 'คำนำหน้าคนที่ 9',
        'prefixs.9' => 'คำนำหน้าคนที่ 10',
        'faculty_id' => 'กลุ่มบทความ',
        'branch_id' => 'สาขาย่อย',
        'degree_id' => 'ระดับบทความ',
        'word_upload' => 'ไฟล์ WORD',
        'pdf_upload' => 'ไฟล์ PDF',
        'stm_upload' => 'ไฟล์แบบคำชี้แจงการปรับแก้ไข',
        'payment_upload' => 'สลิปการชำระเงิน',
        'date' => 'วันที่',
        'topic' => 'หัวข้อ',
        'year' => 'ปี',
        'start' => 'วันที่เริ่มจัดงานประชุม',
        'end' => 'วันสิ้นสุด',
        'name' => 'ชื่อ',
        'file_upload' => 'ไฟล์อัพโหลด',
        'file_comment' => 'ไฟล์คอมเมนต์',
        'file_comment.*' => 'ไฟล์คอมเมนต์',
        'link_upload' => 'ลิงค์อัพโหลด',
        'old_password' => 'รหัสผ่านเก่า',
        'new_password' => 'รหัสผ่านใหม่',
        'final' => 'วันสิ้นสุดจัดงานประชุม',
        'end_research' => 'วันสิ้นสุดการรับบทความ',
        'end_payment' => 'วันสิ้นสุดการชำระเงิน',
        'consideration' => 'ประกาศผลพิจารณา',
        'end_research_edit' => 'วันสิ้นสุดการรับบทความฉบับแก้ไข',
        'end_research_edit_two' => 'วันสิ้นสุดการรับบทความฉบับแก้ไข ครั้งที่ 2',
        'end_poster_and_video' => 'วันสิ้นสุดการส่งไฟล์โปสเตอร์และวิดีโอ',
        'notice_attend' => 'ประกาศรายชื่อผู้เข้าร่วมงานทั้งหมด',
        'present' => 'นำเสนอผลงาน',
        'proceeding' => 'เผยแพร่ Proceeding',
        'room' => 'ห้อง',
        'link' => 'ลิงค์',
        'present_oral_id' => 'รหัสการนำเสนอ',
        'present_poster_id' => 'รหัสการนำเสนอ',
        'position' => 'ลำดับ',
        'topic_id' => 'หัวข้อ',
        'present_id' => 'รูปแบบบทความ',
        'number' => 'เลขหน้า',
        'suggestion_upload' => 'ไฟล์ข้อเสนอแนะ'
    ],

];
