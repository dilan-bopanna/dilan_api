<?php

namespace App\Http\Controllers;

use App\Models\Modules;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ModulesApiController extends Controller
{
    /**
     * @function - To fetch all the Modules data
     *
     * @param -  None
     *
     * @author  - Dilan Bopanna
     *
     * @return - Modules data
     */

    public function getModule()
    {
        try
        {
            $module_data = Modules::latest()->get();
            return response()->json(['status' => 'S', 'message' => 'Data retrived succussfully', 'module_data' => $module_data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'E', 'message' => 'Error processing the data']);
        }
    }

    /**
     * @function - To store Modules data
     *
     * @param -  Request params
     *
     * @author  - Dilan Bopanna
     *
     * @return - Return message with Modules data
     */

    public function storeModule(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'module_name' => 'required|unique:modules,module_name,' . $request->id . '',
        ]);

        try
        {
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()]);
            }
            if ($request->id > 0) {
                $module_data = Modules::where('id', $request->id)->update([
                    'module_name' => $request->module_name,
                    'parent_id' => $request->parent_id,
                ]);
                return response()->json(['status' => 'S', 'message' => 'Request updated succussfully', 'module_data' => $module_data]);
            } else {
                $module_data = Modules::create([
                    'module_name' => $request->module_name,
                    'parent_id' => $request->parent_id,

                ]);
            }
            return response()->json(['status' => 'S', 'message' => 'Request saved succussfully', 'module_data' => $module_data]);

        } catch (\Exception $e) {

            return response()->json(['status' => 'E', 'message' => 'Error processing data']);
        }
    }

    /**
     * @function - To fetch parent and child Modules.
     *
     * @param -  None
     *
     * @author  - Dilan Bopanna
     *
     * @return - Modules data
     */

    public function parentChildModule(Request $request)
    {
        try {
            $module_data = Modules::where('parent_id', 0)
                ->with('children')
                ->select('id', 'module_name as name')
                ->orderBy('id', 'asc')
                ->get();
            return response()->json(['status' => 'S', 'message' => trans('returnmessage.dataretreived'), 'module_data' => $module_data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'E', 'message' => trans('returnmessage.error_processing'), 'error_data' => $e->getmessage()]);
        }
    }

    /**
     * @function - To fetch Modules data by ID
     *
     * @param -  Modules ID
     *
     * @author  - Dilan Bopanna
     *
     * @return - Modules data
     */

    public function getModuleById(Request $request)
    {
        try {

            $module_data = Modules::where('id', $request->id)->first();

            return response()->json(['status' => 'S', 'message' => 'Data retrived successfully', 'module_data' => $module_data]);

        } catch (Exception $e) {
            return response()->json(['status' => 'E', 'message' => 'Error processing data']);
        }

    }

    /**
     * @function - To delete the Modules data
     *
     * @param -  Modules ID
     *
     * @author  - Dilan Bopanna
     *
     * @return - Modules data
     */

    public function deleteModule(Request $request)
    {

        try {
            $module_data = Modules::find($request->module_id)->delete();
            return response()->json(['status' => 'S', 'message' => 'Data deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'E', 'message' => 'Error processing data']);
        }

    }

}
