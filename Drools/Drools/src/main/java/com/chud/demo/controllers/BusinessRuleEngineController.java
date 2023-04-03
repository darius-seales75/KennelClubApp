package com.chud.demo.controllers;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RestController;

import com.chud.demo.models.SampleModel;
import com.chud.demo.services.IBusinessRuleEngineService;

@RestController
public class BusinessRuleEngineController {
   
	@Autowired
	private IBusinessRuleEngineService bre;
	
	@GetMapping("/executeRule")  
	public SampleModel executeRule(@RequestBody SampleModel test)  
	{  
		try {
			System.out.println("Exception:"+test.toString());
			return bre.executeRule(test);
		} catch (Exception e) { 
			// TODO Auto-generated catch block
			System.out.println("Exception:"+e);
		}  
		return null;
	}  

	
}
