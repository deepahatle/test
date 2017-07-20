<?php

use Phinx\Migration\AbstractMigration;

class AddNewTestData extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->execute('delete from test_master; delete from department_master; delete from lab_test; delete from user_visit_tests;');

        $table = $this->table("test_master");
        $table->renameColumn('lower_value', 'lower_value_male');
        $table->renameColumn('higher_value', 'higher_value_male');

        $table->addColumn('lower_value_female', 'string', array('limit' => 50, 'null' => true))
            ->addColumn('higher_value_female', 'string', array('limit' => 50, 'null' => true))
            ->addColumn('lower_value_child', 'string', array('limit' => 50, 'null' => true))
            ->addColumn('higher_value_child', 'string', array('limit' => 50, 'null' => true))
            ->addColumn('unit', 'string', array('limit' => 50, 'null' => true))
            ->update();

        $dataArray = [
            'Hematology' => [
                [
                    'name' => 'HEMATOCRIT (HCT)',
                    'lower_value_male' => '40',
                    'higher_value_male' => '54',
                    'lower_value_female' => '37',
                    'higher_value_female' => '47',
                    'lower_value_child' => '50',
                    'higher_value_child' => '62',
                    'unit' => '%'
                ],
                [
                    'name' => 'HEMOGLOBIN (HGB)',
                    'lower_value_male' => '14',
                    'higher_value_male' => '18',
                    'lower_value_female' => '12',
                    'higher_value_female' => '16',
                    'lower_value_child' => '14',
                    'higher_value_child' => '20',
                    'unit' => 'g/dl'
                ],
                [
                    'name' => 'MCH (Mean Corpuscular Hemoglobin)',
                    'lower_value_male' => '27',
                    'higher_value_male' => '33',
                    'lower_value_female' => '27',
                    'higher_value_female' => '33',
                    'lower_value_child' => '27',
                    'higher_value_child' => '33',
                    'unit' => 'pg'
                ],
                [
                    'name' => 'MCV (Mean Corpuscular Volume)',
                    'lower_value_male' => '80',
                    'higher_value_male' => '100',
                    'lower_value_female' => '80',
                    'higher_value_female' => '100',
                    'lower_value_child' => '80',
                    'higher_value_child' => '100',
                    'unit' => 'fl'
                ],
                [
                    'name' => 'MCHC (Mean Corpuscular Hemoglobin Concentration)',
                    'lower_value_male' => '32',
                    'higher_value_male' => '36',
                    'lower_value_female' => '32',
                    'higher_value_female' => '36',
                    'lower_value_child' => '32',
                    'higher_value_child' => '36',
                    'unit' => '%'
                ],
                [
                    'name' => 'R.B.C. (Red Blood Cell Count)',
                    'lower_value_male' => '4.2',
                    'higher_value_male' => '5.6',
                    'lower_value_female' => '3.9',
                    'higher_value_female' => '5.2',
                    'lower_value_child' => '3.9',
                    'higher_value_child' => '3.9',
                    'unit' => 'mill/mcl'
                ],
                [
                    'name' => 'W.B.C. (White Blood Cell Count)',
                    'lower_value_male' => '3.8',
                    'higher_value_male' => '10.8',
                    'lower_value_female' => '3.8',
                    'higher_value_female' => '10.8',
                    'lower_value_child' => '3.8',
                    'higher_value_child' => '10.8',
                    'unit' => 'thous/mcl'
                ],
                [
                    'name' => 'PLATELET COUNT',
                    'lower_value_male' => '130',
                    'higher_value_male' => '400',
                    'lower_value_female' => '130',
                    'higher_value_female' => '400',
                    'lower_value_child' => '130',
                    'higher_value_child' => '400',
                    'unit' => 'thous/mcl'
                ],
                [
                    'name' => 'NEUTROPHILS and NEUTROPHIL COUNT',
                    'lower_value_male' => '48',
                    'higher_value_male' => '73',
                    'lower_value_female' => '48',
                    'higher_value_female' => '73',
                    'lower_value_child' => '30',
                    'higher_value_child' => '60',
                    'unit' => '%'
                ],
                [
                    'name' => 'LYMPHOCYTES and LYMPHOCYTE COUNT',
                    'lower_value_male' => '18',
                    'higher_value_male' => '48',
                    'lower_value_female' => '18',
                    'higher_value_female' => '48',
                    'lower_value_child' => '25',
                    'higher_value_child' => '50',
                    'unit' => '%'
                ],
                [
                    'name' => 'MONOCYTES and MONOCYTE COUNT',
                    'lower_value_male' => '0',
                    'higher_value_male' => '9',
                    'lower_value_female' => '0',
                    'higher_value_female' => '9',
                    'lower_value_child' => '0',
                    'higher_value_child' => '9',
                    'unit' => '%'
                ],
                [
                    'name' => 'EOSINOPHILS and EOSINOPHIL COUNT',
                    'lower_value_male' => '0',
                    'higher_value_male' => '5',
                    'lower_value_female' => '0',
                    'higher_value_female' => '5',
                    'lower_value_child' => '0',
                    'higher_value_child' => '5',
                    'unit' => '%'
                ],
                [
                    'name' => 'BASOPHILS and BASOPHIL COUNT',
                    'lower_value_male' => '0',
                    'higher_value_male' => '2',
                    'lower_value_female' => '0',
                    'higher_value_female' => '2',
                    'lower_value_child' => '0',
                    'higher_value_child' => '2',
                    'unit' => '%'
                ]
            ],
            'Electrolytes' => [
                [
                    'name' => 'SODIUM',
                    'lower_value_male' => '135',
                    'higher_value_male' => '146',
                    'lower_value_female' => '135',
                    'higher_value_female' => '146',
                    'lower_value_child' => '135',
                    'higher_value_child' => '146',
                    'unit' => 'mEq/L'
                ],
                [
                    'name' => 'POTASSIUM',
                    'lower_value_male' => '3.5',
                    'higher_value_male' => '5.5',
                    'lower_value_female' => '3.5',
                    'higher_value_female' => '5.5',
                    'lower_value_child' => '3.5',
                    'higher_value_child' => '5.5',
                    'unit' => 'mEq/L'
                ],
                [
                    'name' => 'CHLORIDE',
                    'lower_value_male' => '95',
                    'higher_value_male' => '112',
                    'lower_value_female' => '95',
                    'higher_value_female' => '112',
                    'lower_value_child' => '95',
                    'higher_value_child' => '112',
                    'unit' => 'mEq/L'
                ],
                [
                    'name' => 'CO2 (Carbon Dioxide)',
                    'lower_value_male' => '22',
                    'higher_value_male' => '32',
                    'lower_value_female' => '22',
                    'higher_value_female' => '32',
                    'lower_value_child' => '20',
                    'higher_value_child' => '28',
                    'unit' => 'mEq/L'
                ],
                [
                    'name' => 'CALCIUM',
                    'lower_value_male' => '8.5',
                    'higher_value_male' => '10.3',
                    'lower_value_female' => '8.5',
                    'higher_value_female' => '10.3',
                    'lower_value_child' => '8.5',
                    'higher_value_child' => '10.3',
                    'unit' => 'mEq/L'
                ],
                [
                    'name' => 'PHOSPHORUS',
                    'lower_value_male' => '2.5',
                    'higher_value_male' => '4.5',
                    'lower_value_female' => '2.5',
                    'higher_value_female' => '4.5',
                    'lower_value_child' => '3',
                    'higher_value_child' => '6',
                    'unit' => 'mEq/L'
                ],
                [
                    'name' => 'ANION GAP (Sodium + Potassium - CO2 + Chloride)',
                    'lower_value_male' => '4',
                    'higher_value_male' => '14',
                    'lower_value_female' => '4',
                    'higher_value_female' => '14',
                    'lower_value_child' => '4',
                    'higher_value_child' => '14',
                    'unit' => 'mEq/L'
                ],
                [
                    'name' => 'CALCIUM/PHOSPHORUS Ratio',
                    'lower_value_male' => '2.3',
                    'higher_value_male' => '3.3',
                    'lower_value_female' => '2.3',
                    'higher_value_female' => '3.3',
                    'lower_value_child' => '1.3',
                    'higher_value_child' => '3.3',
                    'unit' => ''
                ],
                [
                    'name' => 'SODIUM/POTASSIUM',
                    'lower_value_male' => '26',
                    'higher_value_male' => '38',
                    'lower_value_female' => '26',
                    'higher_value_female' => '38',
                    'lower_value_child' => '26',
                    'higher_value_child' => '38',
                    'unit' => ''
                ]
            ],
            'Hepatic Enzymes' => [
                [
                    'name' => 'AST (Serum Glutamic-Oxalocetic Transaminase - SGOT)',
                    'lower_value_male' => '0',
                    'higher_value_male' => '42',
                    'lower_value_female' => '0',
                    'higher_value_female' => '42',
                    'lower_value_child' => '0',
                    'higher_value_child' => '42',
                    'unit' => 'U/L'
                ],
                [
                    'name' => 'ALT (Serum Glutamic-Pyruvic Transaminase - SGPT)',
                    'lower_value_male' => '0',
                    'higher_value_male' => '48',
                    'lower_value_female' => '0',
                    'higher_value_female' => '48',
                    'lower_value_child' => '0',
                    'higher_value_child' => '48',
                    'unit' => 'U/L'
                ],
                [
                    'name' => 'ALKALINE PHOSPHATASE',
                    'lower_value_male' => '20',
                    'higher_value_male' => '125',
                    'lower_value_female' => '20',
                    'higher_value_female' => '125',
                    'lower_value_child' => '40',
                    'higher_value_child' => '400',
                    'unit' => 'U/L'
                ],
                [
                    'name' => 'GGT (Gamma-Glutamyl Transpeptidase)',
                    'lower_value_male' => '0',
                    'higher_value_male' => '65',
                    'lower_value_female' => '0',
                    'higher_value_female' => '45',
                    'lower_value_child' => '0',
                    'higher_value_child' => '45',
                    'unit' => 'U/L'
                ],
                [
                    'name' => 'LDH (Lactic Acid Dehydrogenase)',
                    'lower_value_male' => '0',
                    'higher_value_male' => '250',
                    'lower_value_female' => '0',
                    'higher_value_female' => '250',
                    'lower_value_child' => '0',
                    'higher_value_child' => '250',
                    'unit' => 'U/L'
                ],
                [
                    'name' => 'BILIRUBIN, TOTAL',
                    'lower_value_male' => '0',
                    'higher_value_male' => '1.3',
                    'lower_value_female' => '0',
                    'higher_value_female' => '1.3',
                    'lower_value_child' => '0',
                    'higher_value_child' => '1.3',
                    'unit' => 'mg/dl'
                ]
            ],
            'Renal' => [
                [
                    'name' => 'B.U.N. (Blood Urea Nitrogen)',
                    'lower_value_male' => '7',
                    'higher_value_male' => '25',
                    'lower_value_female' => '7',
                    'higher_value_female' => '25',
                    'lower_value_child' => '7',
                    'higher_value_child' => '25',
                    'unit' => 'mg/dl'
                ],
                [
                    'name' => 'CREATININE',
                    'lower_value_male' => '0.7',
                    'higher_value_male' => '1.4',
                    'lower_value_female' => '0.7',
                    'higher_value_female' => '1.4',
                    'lower_value_child' => '0.7',
                    'higher_value_child' => '1.4',
                    'unit' => 'mg/dl'
                ],
                [
                    'name' => 'URIC ACID',
                    'lower_value_male' => '3.5',
                    'higher_value_male' => '7.5',
                    'lower_value_female' => '2.5',
                    'higher_value_female' => '7.5',
                    'lower_value_child' => '2.5',
                    'higher_value_child' => '7.5',
                    'unit' => 'mg/dl'
                ],
                [
                    'name' => 'BUN/CREATININE',
                    'lower_value_male' => '6',
                    'higher_value_male' => '25',
                    'lower_value_female' => '6',
                    'higher_value_female' => '25',
                    'lower_value_child' => '6',
                    'higher_value_child' => '25',
                    'unit' => ''
                ],
            ],
            'Protein' => [
                [
                    'name' => 'PROTEIN, TOTAL',
                    'lower_value_male' => '6.0',
                    'higher_value_male' => '8.5',
                    'lower_value_female' => '6.0',
                    'higher_value_female' => '8.5',
                    'lower_value_child' => '6.0',
                    'higher_value_child' => '8.5',
                    'unit' => 'g/dl'
                ],
                [
                    'name' => 'ALBUMIN',
                    'lower_value_male' => '3.2',
                    'higher_value_male' => '5.0',
                    'lower_value_female' => '3.2',
                    'higher_value_female' => '5.0',
                    'lower_value_child' => '3.2',
                    'higher_value_child' => '5.0',
                    'unit' => 'g/dl'
                ],
                [
                    'name' => 'GLOBULIN',
                    'lower_value_male' => '2.2',
                    'higher_value_male' => '4.2',
                    'lower_value_female' => '2.2',
                    'higher_value_female' => '4.2',
                    'lower_value_child' => '2.2',
                    'higher_value_child' => '4.2',
                    'unit' => 'g/dl'
                ],
                [
                    'name' => 'A/G RATIO (Albumin/Globulin Ratio)',
                    'lower_value_male' => '0.8',
                    'higher_value_male' => '2.0',
                    'lower_value_female' => '0.8',
                    'higher_value_female' => '2.0',
                    'lower_value_child' => '0.8',
                    'higher_value_child' => '2.0',
                    'unit' => ''
                ]
            ],
            'Lipids' => [
                [
                    'name' => 'A/G RATIO (Albumin/Globulin Ratio)',
                    'lower_value_male' => '120',
                    'higher_value_male' => '240',
                    'lower_value_female' => '120',
                    'higher_value_female' => '240',
                    'lower_value_child' => '120',
                    'higher_value_child' => '240',
                    'unit' => 'mg/dl'
                ],
                [
                    'name' => 'LDL (Low Density Lipoprotein)',
                    'lower_value_male' => '62',
                    'higher_value_male' => '130',
                    'lower_value_female' => '62',
                    'higher_value_female' => '130',
                    'lower_value_child' => '62',
                    'higher_value_child' => '130',
                    'unit' => 'mg/dl'
                ],
                [
                    'name' => 'HDL (High Density Lipoprotein)',
                    'lower_value_male' => '35',
                    'higher_value_male' => '135',
                    'lower_value_female' => '35',
                    'higher_value_female' => '135',
                    'lower_value_child' => '35',
                    'higher_value_child' => '135',
                    'unit' => 'mg/dl'
                ],
                [
                    'name' => 'TRIGLYCERIDES',
                    'lower_value_male' => '0',
                    'higher_value_male' => '200',
                    'lower_value_female' => '0',
                    'higher_value_female' => '200',
                    'lower_value_child' => '0',
                    'higher_value_child' => '200',
                    'unit' => 'mg/dl'
                ],
                [
                    'name' => 'CHOLESTEROL/LDL RATIO',
                    'lower_value_male' => '1',
                    'higher_value_male' => '6',
                    'lower_value_female' => '1',
                    'higher_value_female' => '6',
                    'lower_value_child' => '1',
                    'higher_value_child' => '6',
                    'unit' => ''
                ]
            ],
            'Thyroid' => [
                [
                    'name' => 'THYROXINE (T4)',
                    'lower_value_male' => '4',
                    'higher_value_male' => '12',
                    'lower_value_female' => '4',
                    'higher_value_female' => '12',
                    'lower_value_child' => '4',
                    'higher_value_child' => '12',
                    'unit' => 'ug/dl'
                ],
                [
                    'name' => 'T3-UPTAKE',
                    'lower_value_male' => '27',
                    'higher_value_male' => '47',
                    'lower_value_female' => '27',
                    'higher_value_female' => '47',
                    'lower_value_child' => '27',
                    'higher_value_child' => '47',
                    'unit' => '%'
                ],
                [
                    'name' => 'FREE T4 INDEX (T7)',
                    'lower_value_male' => '4',
                    'higher_value_male' => '12',
                    'lower_value_female' => '4',
                    'higher_value_female' => '12',
                    'lower_value_child' => '4',
                    'higher_value_child' => '12',
                    'unit' => ''
                ],
                [
                    'name' => 'THYROID-STIMULATING HORMONE (TSH)',
                    'lower_value_male' => '0.5',
                    'higher_value_male' => '6',
                    'lower_value_female' => '0.5',
                    'higher_value_female' => '6',
                    'lower_value_child' => '0.5',
                    'higher_value_child' => '6',
                    'unit' => 'miliIU/L'
                ]
            ]
        ];

        foreach ($dataArray as $dept => $testsArray) {

            $deptUUID = $this->getUUID();
            $deptRows[] = [
                'row_id' => $deptUUID,
                'created_by' => 'SYSTEM',
                'created' => date('Y-m-d H:i:s'),
                'last_upd_by' => 'SYSTEM',
                'last_upd' => date('Y-m-d H:i:s'),
                'deleted' => 0,
                'name' => $dept,
                'code' => $dept
            ];

            foreach ($testsArray as $test) {
                $testUUID = $this->getUUID();
                $testRows[] = [
                    'row_id' => $testUUID,
                    'created_by' => 'SYSTEM',
                    'created' => date('Y-m-d H:i:s'),
                    'last_upd_by' => 'SYSTEM',
                    'last_upd' => date('Y-m-d H:i:s'),
                    'deleted' => 0,
                    'name' => $test['name'],
                    'department_id' => $deptUUID,
                    'default_cost' => 0,
                    'lower_value_male' => $test['lower_value_male'],
                    'higher_value_male' => $test['higher_value_male'],
                    'lower_value_female' => $test['lower_value_female'],
                    'higher_value_female' => $test['higher_value_female'],
                    'lower_value_child' => $test['lower_value_child'],
                    'higher_value_child' => $test['higher_value_child'],
                    'unit' => $test['unit'],
                ];
                
                $labs = $this->query('SELECT * FROM lab where deleted = 0;');
                $labTestRows = array();
                foreach ($labs as $lab) {
                    $labTestRows[] = [
                        'row_id' => $this->getUUID(),
                        'created_by' => 'SYSTEM',
                        'created' => date('Y-m-d H:i:s'),
                        'last_upd_by' => 'SYSTEM',
                        'last_upd' => date('Y-m-d H:i:s'),
                        'deleted' => 0,
                        'test_id' => $testUUID,
                        'lab_id' => $lab['row_id'],
                        'cost' => 0
                    ];
                }
            }
            
        }

        // this is a handy shortcut
        $this->insert('department_master', $deptRows);
        $this->insert('test_master', $testRows);
        if(!empty($labTestRows))
            $this->insert('lab_test', $labTestRows);
    }

    public function getUUID(){
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
          mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
          mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
          mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
          mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
          mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
          );
    }
}
