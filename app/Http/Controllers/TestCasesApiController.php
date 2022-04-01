<?php

namespace App\Http\Controllers;

use App\Models\TestCases;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;

class TestCasesApiController extends Controller
{

    /**
     * @function - To fetch the list of Test cases.
     *
     * @param -  Section ID
     *
     * @author  - Dilan Bopanna
     *
     * @return - test cases list array
     */

    public function getTestCases(Request $request)
    {
        try
        {
            $testcases = TestCases::get();
            if ($request->moduleId !== null) {
                $testcases = TestCases::where('module_id', $request->moduleId)->latest()->get();
            }

            return response()->json(['status' => 'S', 'message' => 'Data retrived succussfully', 'testcases' => $testcases]);
        } catch (\Exception $e) {

            return response()->json(['status' => 'E', 'message' => 'Error processing data']);
        }
    }

    /**
     * @function - To store Test cases
     *
     * @param -  $request
     *
     * @author  - Dilan Bopanna
     *
     * @return - Return message with test case array
     */

    public function storeTestCases(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'module_id' => 'required',
            'summary' => 'required',
        ]);

        try
        {
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()]);
            }
            if ($request->id > 0) {
                $testcases = TestCases::where('id', $request->id)->update([
                    'module_id' => $request->module_id,
                    'summary' => $request->summary,
                    'description' => $request->description,
                    'file_name' => $request->filename,
                    'status' => $request->status,
                ]);
                return response()->json(['status' => 'S', 'message' => 'Data updated succussfully', 'testcases' => $testcases]);
            } else {
                $testcases = TestCases::create([
                    'module_id' => $request->module_id,
                    'summary' => $request->summary,
                    'description' => $request->description,
                    'file_name' => $request->filename,
                    'status' => $request->status,
                ]);
            }
            return response()->json(['status' => 'S', 'message' => 'Data saved succussfully', 'testcases' => $testcases]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'E', 'message' => 'Error processing data']);
        }
    }

    /**
     * @function - To fetch the test case based on ID
     *
     * @param -  Test case ID
     *
     * @author  - Dilan Bopanna
     *
     * @return - Test case array
     */

    public function getTestCaseById(Request $request)
    {
        try {
            $testcases = TestCases::find($request->id);
            return response()->json(['status' => 'S', 'message' => 'Data retrived successfully', 'testcases' => $testcases]);
        } catch (Exception $e) {
            return response()->json(['status' => 'E', 'message' => 'Error processing data']);
        }

    }

    /**
     * @function - To delete Test cases
     *
     * @param -  Test case ID
     *
     * @author  - Dilan Bopanna
     *
     * @return - Return message
     */

    public function deleteTestCases(Request $request)
    {
        try {
            $testcases = TestCases::find($request->id)->delete();
            return response()->json(['status' => 'S', 'message' => 'Deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'E', 'message' => 'Error processing data']);
        }

    }

    /**
     * @function - To upload file.
     *
     * @param -  Request
     *
     * @author  - Dilan Bopanna
     *
     * @return - Filename and file path
     */

    public function fileUpload(Request $request)
    {
        try {
            if (request('image')) {

                $base64_str = substr($request->image, strpos($request->image, ",") + 1);

                if ($request->width > 1600) {
                    $image_data = base64_decode($base64_str);
                    $image = Image::make($image_data)->resize($request->width, $request->height, function ($constraint) {
                        $constraint->aspectRatio();
                    })->stream('png', 100);
                } else {
                    $image = base64_decode($base64_str);
                }

                $folderName = $request->folder;
                $safeName = Str::uuid() . '.' . $request->extension;
                $filename = $request->filename . '.' . $request->extension;

                Storage::disk('public')->put($folderName . '/' . $safeName, $image);

                $filewithpath = "/storage/" . $folderName . '/' . $safeName;

                $status = 'S';
                $message = 'File uploaded succussfully';
            } else {
                $status = 'E';
                $filewithpath = '';
                $message = 'File size too large';
            }
            return response()->json(['status' => $status, 'message' => $message, 'filepath' => $filewithpath, 'filename' => $filename]);
        } catch (Exception $file_exception) {
            return response()->json(['status' => 'E', 'message' => 'Error uploading file']);
        }
    }
}
