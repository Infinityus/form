<!-- Sticky Answers Box -->
            <div class="bg-white shadow-md rounded-lg p-6 sticky top-6 h-max sticky-answers">
                <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg h-64 overflow-y-auto">
                    <?php
                        function generateRandomString($length) {
                            return substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', $length)), 0, $length);
                        }
                        
                        function generateRandomNumber($length) {
                            return substr(str_shuffle(str_repeat('0123456789', $length)), 0, $length);
                        }
                        
                        function generateRandomName() {
                            $firstNames = [
                                "Johny", "Jane", "Alice", "Bob", "Charlie", "Grace", "Liam", "Mia", "Noah", "Sophia",
                                "Ethan", "Emma", "Olivia", "James", "Ava", "Benjamin", "Isabella", "Elijah", "Amelia", 
                                "Lucas", "Harper", "Mason", "Evelyn", "Logan", "Abigail", "Alexander", "Emily", "Henry", 
                                "Ella", "William", "Chloe", "Samuel", "Aria", "Michael", "Lily", "Sebastian", "Victoria", 
                                "Jack", "Scarlett", "Daniel", "Zoe", "Jacob", "Stella", "Matthew", "Hazel", "Owen", 
                                "Nora", "Nathan", "Ellie", "Dylan", "Avery", "Caleb", "Riley", "Leo", "Hannah"
                            ];
                            
                            $lastNames = [
                                "Cooper", "Smith", "Johnson", "Brown", "Williams", "Taylor", "Martin", "Jackson", "Thompson", 
                                "White", "Harris", "Clark", "Walker", "Lewis", "Hall", "Allen", "Young", "King", "Wright", 
                                "Hill", "Scott", "Green", "Adams", "Baker", "Mitchell", "Carter", "Phillips", "Campbell", 
                                "Evans", "Turner", "Parker", "Collins", "Edwards", "Stewart", "Morris", "Murphy", "Cook", 
                                "Rogers", "Morgan", "Reed", "Bell", "Cooper", "Ward", "Foster", "Brooks", "Sanders", 
                                "Price", "Bennett", "Wood", "Barnes", "Ross", "Henderson", "Coleman", "Jenkins", "Perry"
                            ];
                            
                            return $firstNames[array_rand($firstNames)] . " " . $lastNames[array_rand($lastNames)];
                        }

                        
                        function generateRandomCompanyData() {
                            $companies = [
                                ["name" => "Tech Innovators Inc", "city" => "Tech Valley", "state" => "California"],
                                ["name" => "Global Solutions Ltd", "city" => "Business City", "state" => "New York"],
                                ["name" => "Summit Enterprises", "city" => "Corporateville", "state" => "Texas"],
                                ["name" => "Bright Future Co", "city" => "Innovation Town", "state" => "Florida"],
                                ["name" => "Velocity Systems", "city" => "Commerce Harbor", "state" => "Illinois"]
                            ];
                            return $companies[array_rand($companies)];
                        }
                        
                        function generateRandomAddress($city, $state) {
                            $streetNames = ["Main", "Oak", "Pine", "Elm", "Maple", "Cedar", "Willow", "Park", "Broadway", "Hill"];
                            $streetNumber = rand(100, 9999);
                            $streetName = $streetNames[array_rand($streetNames)];
                            $zipCode = rand(10000, 99999);
                            return "{$streetNumber} {$streetName} St, {$city}, {$state} {$zipCode}";
                        }
                        
                        function generateRandomEmail($companyName) {
                            $cleanName = strtolower(str_replace(' ', '', $companyName));
                            return "user" . generateRandomNumber(3) . "@{$cleanName}.com";
                        }
                        
                        // Generate matching data
                        $companyData = generateRandomCompanyData();
                        $companyName = $companyData['name'];
                        $companyCity = $companyData['city'];
                        $companyState = $companyData['state'];
                        $companyAddress = generateRandomAddress($companyCity, $companyState);
                        $companyZipCode = "RM" . generateRandomNumber(5);
                        
                        // Generate answers
                        $answers = [
                            "application_number" => "AFF" . generateRandomNumber(5),
                            "employee_security_number" => generateRandomNumber(10),
                            "employee_identification_number" => generateRandomNumber(12),
                            "employee_name" => generateRandomName(),
                            "address" => generateRandomAddress($companyCity, $companyState),
                            "control_number" => generateRandomNumber(13),
                            "employee_wages_and_tips" => number_format(rand(15000, 50000), 0),
                            "social_security_wages" => number_format(rand(5000, 15000), 0),
                            "medical_wages" => number_format(rand(2000, 10000), 0),
                            "federal_income_tax" => rand(10, 30) . "% Federal tax",
                            "sofia_security_tax" => rand(3, 10) . "% Sofia tax",
                            "medicare_tax" => rand(1, 5) . "% Medicare tax",
                            "state" => $companyState,
                            "company_name" => $companyName,
                            "company_address" => $companyAddress,
                            "company_zip_code" => $companyZipCode,
                            "employ_state_id" => generateRandomNumber(17),
                            "telephone_number" => "+44" . generateRandomNumber(10),
                            "fax_number" => generateRandomNumber(9),
                            "e_mail_address" => generateRandomEmail($companyName),
                            "payer_name" => $companyName,
                            "payer_federal_id_number" => generateRandomNumber(15),
                            "receipt_id_number" => generateRandomNumber(12),
                            "af_license" => "Af" . generateRandomString(10),
                            "rms_id" => "rms-" . generateRandomNumber(5) . "-" . generateRandomNumber(5) . "-" . generateRandomNumber(5)
                        ];

                    // Display answers in numbered format
                    $counter = 1;
                    foreach ($answers as $key => $value) {
                        echo "<p><strong>$counter.</strong> $value</p>";
                        $counter++;
                    }

                    echo "<input type='hidden' id='answers-data' value='" . json_encode($answers) . "'>";
                    ?>
                </div>
            </div>
