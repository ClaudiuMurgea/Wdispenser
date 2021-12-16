<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RestrictionList;
use App\Models\AdminRestrictionsTemplate;

use Illuminate\Http\Request;

class AccessRulesController extends Controller
{
    //

    // get all access rules templates
    public function accessRulesTemplates(){
        $templatesList = $this->getAllTemplatesNames();

        return view('layouts.admin.access_rules_templates')->with('templates', $templatesList);
    }

    public function accessRulesTemplate($templateName){
        $accessRulessTree = [];

        $accessRulesList = (new RestrictionList())->on('mysql_main')->get()->toArray();
        //$restrictionsTemplate =(new AdminRestrictionsTemplate())->where('TemplateName', $templateName)->get()->toArray();
        $restrictionsTemplate = (new AdminRestrictionsTemplate())
            ->where('TemplateName', $templateName)
            ->get()
            ->mapWithKeys(function($item){ return [$item['Restriction'] => $item['RestrictionValue']]; })
            ->toArray();

        if(!empty($accessRulesList)){
            foreach($accessRulesList as $accessRule){
                $children = explode("/", $accessRule['Restriction']);
                $isRoot = count($children) == 1;

                $name = array_pop($children);

                // $accessRule['children'] = [];
                $accessRule['r_name'] = $name;
                $accessRule['f_name'] = strtolower(str_replace('/', '', str_replace(' ', '', $accessRule['Restriction'])));
                $accessRule['UserValue'] = $restrictionsTemplate[$accessRule['Restriction']] ?? '';
                $accessRule['additional'] = explode(",", $accessRule['Additional']);
                // Parinte - de la primul nivel
                if ($isRoot) {
                    $accessRulessTree[$name] = $accessRule;
                // Copil - peste nivelul 1
                } else {
                    $children[] = $name;
                    $key = implode('.children.', $children);

                    \Arr::set($accessRulessTree, $key, $accessRule);
                }
            }
        }

        $responseArray = [
            "access_rules_tree"     => $accessRulessTree, 
            "templates"             => $this->getAllTemplatesNames()
        ];

        return response()->json($responseArray);
    }

    public function accessRulesDefaults(){
        $accessRulessTree = [];
        $restrictionsList = (new RestrictionList())->on('mysql_main')->get()->toArray();

        if(!empty($restrictionsList)){
            foreach($restrictionsList as $restriction){
                $children = explode("/", $restriction['Restriction']);
                $isRoot = count($children) == 1;

                $name = array_pop($children);

                // $accessRule['children'] = [];
                $restriction['r_name'] = $name;
                $restriction['f_name'] = strtolower(str_replace('/', '', str_replace(' ', '', $restriction['Restriction'])));
                $restriction['UserValue'] = $userRestrictions[$restriction['Restriction']] ?? '';
                $restriction['additional'] = explode(",", $restriction['Additional']);
                // Parinte - de la primul nivel
                if ($isRoot) {
                    $accessRulessTree[$name] = $restriction;
                // Copil - peste nivelul 1
                } else {
                    $children[] = $name;
                    $key = implode('.children.', $children);

                    \Arr::set($accessRulessTree, $key, $restriction);
                }
            }
        }

        return response()->json($accessRulessTree);
    }

    public function accessRulesTemplateStore(Request $request){
        $templateName = $request->_template_name ?? null;
        $templateName = trim($templateName);

        // template name required
        if(empty($templateName)) return response()->json(['status' => false, 'message' => 'Template name required!']);

        $selectedRestrictions = $request->all();
        //dd($selectedRestrictions);

        // template name unique
        //$existingTemplate = AdminRestrictionTemplate::where('TemplateName', $templateName)->take(1)->get();
        //if(!empty($existingTemplate)) return response()->json(['status' => false, 'message' => 'Template name already recorded!']);

        // reload restrictions list
        $accessRulesList = (new RestrictionList())->on('mysql_main')->get()->toArray();
        
        $restrictionsTemplate = [];
        if(!empty($accessRulesList)){
            foreach($accessRulesList as $accessRule){
                $searchKey = strtolower(str_replace('/', '', str_replace(' ', '', $accessRule['Restriction'])));
                if($accessRule['Type'] == 'ShowHide'){
                    $usersRestriction = 'Hide';
                    if(isset($selectedRestrictions[$searchKey]) && $selectedRestrictions[$searchKey] == 'on') $usersRestriction = 'Show';
                }
                elseif($accessRule['Type'] == 'Choice'){
                    $usersRestriction = $selectedRestrictions[$searchKey] ?? 'Hide';
                }
                elseif($accessRule['Type'] == 'CheckList'){
                    $usersRestriction = '';
                    if(isset($selectedRestrictions[$searchKey]) && is_array($selectedRestrictions[$searchKey])){
                        $userRestrictions = implode(',', $selectedRestrictions[$searchKey]);
                    }
                }

                $restrictionsTemplate[] = [
                    'TemplateName'      => $templateName,
                    'Restriction'       => $accessRule['Restriction'],
                    'RestrictionValue'  => $usersRestriction
                ];
            }

            AdminRestrictionsTemplate::insert($restrictionsTemplate);
        }

        return response()->json(['status' => true, 'message' => 'Template recorded!']);

    }

    public function accessRulesTemplateClone(Request $request){
        $userRestrictions = $request->all()['userRestrictions'];
        //$userRestrictions = //json_decode($userRestrictions ?? '{}');

        dd($userRestrictions);

        if(!empty($userRestrictions)){
            foreach($userRestrictions as $restriction){print_r($restriction);

            }
        }

        $accessRulessTree = [];

        return response()->json(json_decode($userRestrictions));
    }

    private function getAllTemplatesNames(){
        return (new AdminRestrictionsTemplate)->select('TemplateName')->groupBy('TemplateName')->get()->toArray();
    }
}
