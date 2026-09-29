<?php

/*
|--------------------------------------------------------------------------
| Page sections ("أقسام الصفحات")
|--------------------------------------------------------------------------
|
| Declares which static texts of which pages the admin can edit from the
| dashboard. Everything here is driven by this file:
|
|   - the pages listed under Settings > Page sections,
|   - the blocks and inputs rendered on the edit screen,
|   - the value used on the site when the admin never filled the field in.
|
| Adding a new editable text = one entry below. No migration, no new table.
| Read a value in a blade with:  page_text('contact.side.title')
|
| Field types: text | textarea
|
*/

return [

    'contact' => [

        'label' => ['ar' => 'صفحة اتصل بنا', 'en' => 'Contact page'],
        'icon'  => 'mdi mdi-email-outline',
        'route' => 'site.contact-us',

        'sections' => [

            'hero' => [
                'label' => ['ar' => 'ترويسة الصفحة', 'en' => 'Page heading'],
                'fields' => [
                    'title' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'العنوان الرئيسي', 'en' => 'Main heading'],
                        'default' => ['ar' => 'اتصل بنا', 'en' => 'Contact Us'],
                    ],
                    'subtitle' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'سطر تحت العنوان (اختياري)', 'en' => 'Line under the heading (optional)'],
                        'default' => ['ar' => '', 'en' => ''],
                    ],
                ],
            ],

            'info_cards' => [
                'label' => ['ar' => 'عناوين كروت بيانات التواصل', 'en' => 'Contact info card titles'],
                'note'  => [
                    'ar' => 'القيم نفسها (الهاتف والبريد والعنوان) بتتعدل من إعدادات النظام.',
                    'en' => 'The values themselves (phone, email, address) are edited in the system settings.',
                ],
                'fields' => [
                    'phone' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'عنوان كارت الهاتف', 'en' => 'Phone card title'],
                        'default' => ['ar' => 'الهاتف', 'en' => 'Phone'],
                    ],
                    'email' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'عنوان كارت البريد', 'en' => 'Email card title'],
                        'default' => ['ar' => 'البريد الإلكتروني', 'en' => 'Email'],
                    ],
                    'address' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'عنوان كارت العنوان', 'en' => 'Address card title'],
                        'default' => ['ar' => 'عنوان', 'en' => 'Address'],
                    ],
                ],
            ],

            'side' => [
                'label' => ['ar' => 'البلوك الجانبي (جنب الفورم)', 'en' => 'Side block (next to the form)'],
                'note'  => [
                    'ar' => 'مفيش نص افتراضي هنا: أي حقل تسيبه فاضي مش هيظهر على الصفحة أصلاً.',
                    'en' => 'No default here: a field left empty is not rendered on the page at all.',
                ],
                'fields' => [
                    // Deliberately no defaults: an empty field must leave the
                    // page blank rather than fall back to any text.
                    'title' => [
                        'type'  => 'text',
                        'label' => ['ar' => 'العنوان', 'en' => 'Heading'],
                    ],
                    'description' => [
                        'type'  => 'textarea',
                        'label' => ['ar' => 'الوصف', 'en' => 'Description'],
                    ],
                ],
            ],

            'form' => [
                'label' => ['ar' => 'فورم إرسال الرسالة', 'en' => 'Message form'],
                'fields' => [
                    'name_label' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'عنوان حقل الاسم', 'en' => 'Name label'],
                        'default' => ['ar' => 'الاسم', 'en' => 'Name'],
                    ],
                    'name_placeholder' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'النص الإرشادي لحقل الاسم', 'en' => 'Name placeholder'],
                        'default' => ['ar' => 'أدخل اسمك', 'en' => 'Enter Your Name'],
                    ],
                    'phone_label' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'عنوان حقل الهاتف', 'en' => 'Phone label'],
                        'default' => ['ar' => 'الهاتف', 'en' => 'Phone'],
                    ],
                    'phone_placeholder' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'النص الإرشادي لحقل الهاتف', 'en' => 'Phone placeholder'],
                        'default' => ['ar' => 'ادخل رقم الهاتف', 'en' => 'Enter Your Phone'],
                    ],
                    'email_label' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'عنوان حقل البريد', 'en' => 'Email label'],
                        'default' => ['ar' => 'البريد الإلكتروني', 'en' => 'Email'],
                    ],
                    'email_placeholder' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'النص الإرشادي لحقل البريد', 'en' => 'Email placeholder'],
                        'default' => ['ar' => 'أدخل بريدك الإلكتروني', 'en' => 'Enter Your Email'],
                    ],
                    'subject_label' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'عنوان حقل الموضوع', 'en' => 'Subject label'],
                        'default' => ['ar' => 'الموضوع', 'en' => 'Subject'],
                    ],
                    'subject_placeholder' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'النص الإرشادي لحقل الموضوع', 'en' => 'Subject placeholder'],
                        'default' => ['ar' => 'ادخل الموضوع', 'en' => 'Enter Your Subject'],
                    ],
                    'message_label' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'عنوان حقل الرسالة', 'en' => 'Message label'],
                        'default' => ['ar' => 'رسالة', 'en' => 'Message'],
                    ],
                    'message_placeholder' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'النص الإرشادي لحقل الرسالة', 'en' => 'Message placeholder'],
                        'default' => ['ar' => 'اكتب رسالتك', 'en' => 'Write Your Message'],
                    ],
                    'button' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'نص زر الإرسال', 'en' => 'Submit button text'],
                        'default' => ['ar' => 'إرسال', 'en' => 'Send Message'],
                    ],
                    'success' => [
                        'type'    => 'text',
                        'label'   => ['ar' => 'رسالة النجاح بعد الإرسال', 'en' => 'Success message'],
                        'default' => [
                            'ar' => 'تم إرسال رسالتك بنجاح!',
                            'en' => 'Your message has been sent successfully!',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
