package com.chud.demo.util;

import java.util.ArrayList;
import java.util.List;

import org.drools.core.event.DefaultAgendaEventListener;
import org.kie.api.KieBase;
import org.kie.api.KieServices;
import org.kie.api.event.rule.AfterMatchFiredEvent;
import org.kie.api.event.rule.MatchCreatedEvent;
import org.kie.api.runtime.KieContainer;
import org.kie.api.runtime.KieSession;
import org.kie.api.runtime.KieSessionConfiguration;
import org.kie.api.runtime.rule.FactHandle;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Component;

import com.chud.demo.models.SampleModel;

//import lombok.extern.slf4j.Slf4j;

//@Slf4j
@Component
public class RuleEngineUtil {

	private static org.slf4j.Logger logger = LoggerFactory.getLogger(RuleEngineUtil.class);
	private KieContainer kieContainer = null;
	private KieServices ks;
	private KieBase base;

	public RuleEngineUtil() {
		try {
			//KieContainer kieContainer = null;
			ks = KieServices.Factory.get();
			kieContainer = ks.getKieClasspathContainer();
			base = kieContainer.getKieBase("KBase1");

		} catch (Exception e) {
			System.out.println("EXCEPTION:  " + e.getMessage());
		}

	}

	public SampleModel execute(SampleModel model) {
		
		try {
			
			KieSession session1 = kieContainer.newKieSession("KSession1_1");
			
			KieSessionConfiguration sessionconf = ks.newKieSessionConfiguration();
			session1.addEventListener( new DefaultAgendaEventListener() {

				@Override
				public void afterMatchFired(AfterMatchFiredEvent event) {
					System.out.println("Rule fired: " + event.getMatch().getRule().getName());
					super.afterMatchFired(event);
				}

				@Override
				public void matchCreated(MatchCreatedEvent event) {
					System.out.println("Match Created: " + event.getMatch().getRule().getName());
					super.matchCreated(event);
				}
			});
			System.out.println("");
			System.out.println("***** SESSION 1 ******");
			
			List<FactHandle> facts = new ArrayList<FactHandle>(); 
			
			facts.add(session1.insert(model));
			session1.fireAllRules();
			session1.dispose();
			
			
		}catch(Exception e) {
			System.out.println("EXCEPTION:  " + e.getMessage());
		}
		
		return model;
		
	}

}
