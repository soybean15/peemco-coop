<?php
namespace App\Services\LoanType;

use App\Models\LoanReleaseDate;
use App\Models\LoanType;
use App\Models\LoanTypeUser;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LoanTypeService
{
    public $loanType;

    public function __construct($loanType = null)
    {
        $this->loanType = $loanType;
    }

    public function getUsersExcept()
    {
        if (!$this->loanType) {
            return User::query(); // Return an empty collection if no loanType is set
        }

        return User::whereDoesntHave('loanTypes', function ($query) {
            $query->where('loan_type_id', $this->loanType->id);
        });
    }

    public function getUsers($search = null)
    {
        if (!$this->loanType) {
            return User::query()->whereRaw('0 = 1');
        }

        if ($this->loanType->apply_to == 'all') {
            return User::query();
        }

        return User::whereHas('loanTypes', function ($query) {
            $query->where('loan_type_id', $this->loanType->id);
        });
    }

    public function addUsers($user_ids)
    {
        foreach ($user_ids as $user_id) {
            LoanTypeUser::create(['user_id' => $user_id, 'loan_type_id' => $this->loanType->id]);
        }
    }

    private function validateForm($data)
    {
        $form = $data['form'];
        $rules = [
            'form.loan_type' => 'required|max:50',
            'form.minimum_amount' => 'required|numeric',
            'form.charges' => 'required|numeric',
            'form.type' => 'required',
        ];

        $messages = [
            'form.loan_type.required' => 'The loan type is required.',
            'form.loan_type.max' => 'The loan type cannot exceed 50 characters.',
            'form.minimum_amount.required' => 'The minimum amount is required.',
            'form.minimum_amount.numeric' => 'The minimum amount must be a number.',
            'form.charges.required' => 'Charges are required.',
            'form.charges.numeric' => 'Charges must be a number.',
            'form.type.required' => 'The type is required.',
            'releaseDates.*.start.required' => 'The start date is required for each release date.',
            'releaseDates.*.end.required' => 'The end date is required for each release date.',
        ];

        // Add conditional rules based on the form type
        if ($form['type'] == 'regular' || $form['type'] == 'flexible') {
            $rules['form.annual_rate'] = 'required|numeric';
            $rules['form.maximum_amount'] = 'required|numeric|gte:form.minimum_amount';
            $rules['form.penalty'] = 'required|numeric';
            $rules['form.grace_period'] = 'required|numeric';
            $rules['form.maximum_period'] = 'required|numeric';
        } elseif ($form['type'] == 'cash_advance') {
            // Validate releaseDates for "cash_advance" type
            $rules['releaseDates'] = 'required|array|min:1';
            $rules['releaseDates.*.start'] = 'required';
            $rules['releaseDates.*.end'] = 'required';
        }

        Validator::make($data, $rules, $messages)->validate();
    }

    private function handleReleaseDates($loanTypeId, $releaseDates)
    {
        foreach ($releaseDates as $date) {
            LoanReleaseDate::create([
                'loan_type_id' => $loanTypeId,
                'from' => $date['start'],
                'to' => $date['end'],
            ]);
        }
    }

    public function store($data)
    {
        $this->validateForm($data);

        $form = $data['form'];
        $releaseDates = $data['releaseDates'];

        // Create LoanType
        $loanType = LoanType::create($form);

        // If the type is 'cash_advance', handle releaseDates
        if ($form['type'] == 'cash_advance' && count($releaseDates) > 0) {
            $this->handleReleaseDates($loanType->id, $releaseDates);
        }

        // Store loan type ID in session
        session()->put('loan_type_id', $loanType->id);
    }

    public function update($data)
    {
        $this->validateForm($data);

        $form = $data['form'];
        $releaseDates = $data['releaseDates'];

        // Update LoanType
        $this->loanType->update($form);

        // Delete existing release dates and handle new ones
        $this->loanType->releaseDates()->delete();

        // If the type is 'cash_advance', handle releaseDates
        if ($form['type'] == 'cash_advance' && count($releaseDates) > 0) {
            $this->handleReleaseDates($this->loanType->id, $releaseDates);
        }
    }
}
